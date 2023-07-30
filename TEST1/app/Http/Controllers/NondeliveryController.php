<?php

namespace App\Http\Controllers;
use App\Models\NonDelivery;
use App\Models\NonDeliveryDetail;
use App\Models\Huutou;
use Validator;  //バリデーションを使えるようにする

use Illuminate\Http\Request;
use App\Models\Gyoumu;
use App\Models\Return_reason;
use App\Models\Label;


use Illuminate\Support\Facades\DB;

class NondeliveryController extends Controller
{
    //
    private $non_delivery_controller;
    private $non_delivery_detail_resend_controller;
    private $non_delivery_detail_waste_controller;

    private $temporary_flag_cd = 1; //一時登録のフラグCD
    private $order_flag_cd = 2; //指示待ちのフラグCD
    private $waste_flag_cd = 5; //廃棄のフラグCD
    private $waste_complete_flag_cd = 6; //廃棄完了のフラグCD

    private $resend_flag_cd = 3; //再発送のフラグCD
    private $resend_complete_flag_cd = 4; //再発送完了のフラグCD
    
    //コンストラクタ （このクラスが呼ばれたら最初に処理をする）

    public function __construct()
    {
        $today = date('Y-m-d');
        // $this->middleware('auth');

       

        $this->non_delivery_controller  = NonDelivery::orderBy('date','asc')
        ->where('creation_flag', '=', 0)
        ->join('gyoumu', 'non_delivery.gyoumu_cd', '=', 'gyoumu.id')
        ->whereDate('date', $today)
        ->get();

        $this->non_delivery_detail_resend_controller  =NonDeliveryDetail::orderBy('huutous.status_cd','asc')->orderBy('gyoumu_cd','asc')
        ->orderBy('date','asc')
        ->join('huutous', 'huutous.id', '=', 'huutou_cd')
        ->join('statuses', 'statuses.id', '=', 'huutous.status_cd')
        ->where('statuses.id', '=', $this->resend_flag_cd)
        ->get();

        $this->non_delivery_detail_waste_controller  =NonDeliveryDetail::orderBy('huutous.status_cd','asc')->orderBy('gyoumu_cd','asc')
        ->orderBy('date','asc')
        ->join('huutous', 'huutous.id', '=', 'huutou_cd')
        ->join('statuses', 'statuses.id', '=', 'huutous.status_cd')
        ->where('statuses.id', '=', $this->waste_flag_cd)
        ->get();


    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $gyoumu = Gyoumu::orderBy('id','asc')->get();
        $return_reason = Return_reason::orderBy('id','asc')->get();
        
        $today = date('Y-m-d');

        //当日のラベル印刷枚数を表示
        $today_label_number_db = DB::table('label_print')
            ->select('all_number')
            ->whereDate('non_delivery_data', $today)
            ->get();
        //$today_label_number_db[0]->all_numberがNULLでなければ、$today_label_numberに代入
        // NULLなら0を代入
        $today_label_number = $today_label_number_db[0]->all_number ?? 0;
        return view('non_delivery',['gyoumu' => $gyoumu],['return_reason' => $return_reason,'today_label_number' => $today_label_number]);
    }

    //不着データ作成画面へ
    public function index_creation()
    {

        $today = date('Y-m-d');

        $non_delivery = $this->non_delivery_controller;

        //当日のラベル印刷枚数を表示
        $non_delivery_sum = NonDelivery::select(DB::raw('DATE(date) AS date'), DB::raw('SUM(number) AS count'))
                ->groupBy(DB::raw('DATE(date)'))
                ->where('creation_flag', '=', 0)
                ->whereDate('date', $today)
                ->get();

        //$today_label_number_db[0]->all_numberがNULLでなければ、$today_label_numberに代入
        // NULLなら0を代入
        $today_non_delivery_number = $non_delivery_sum[0]->count ?? 0;
        return view('non_delivery_data_creation',['non_delivery' => $non_delivery,'today_non_delivery_number' => $today_non_delivery_number]);

    }

    public function index_resend()
    {

        $today = date('Y-m-d');

        $non_delivery_detail = $this->non_delivery_detail_resend_controller;
        // dd($non_delivery_detail);



        //$today_label_number_db[0]->all_numberがNULLでなければ、$today_label_numberに代入
        // NULLなら0を代入
        $today_non_delivery_number = $non_delivery_detail->count();
        return view('resend',['non_delivery' => $non_delivery_detail,'today_non_delivery_number' => $today_non_delivery_number]);

    }

    public function index_waste()
    {

        $today = date('Y-m-d');

        $non_delivery = $this->non_delivery_detail_waste_controller;

        // NULLなら0を代入
        $today_non_delivery_number = $non_delivery->count();
        return view('waste',['non_delivery' => $non_delivery,'today_non_delivery_number' => $today_non_delivery_number]);

    }


    //バリデーション
    public function getNondeliverylValidator(Request $request) {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'kakitome_number' => 'required | min:1 | max:9',
            'manage_number' => 'required | min:1 | max:9',
            'huutou_qr_number' => 'required | min:1 | max:9',
        ]);
        return $validator;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    // 一時的な不着登録 一気にDBに書き込むようにする　まずはSESSIONに保存しておく
    // 封筒1通の情報をセッションへ登録
    public function temporary_store(Request $request)
    {
        // スタートのセッションを作る（スタートだとモーダルウインドウがオープン）
        session(['start' => 'OK']);

        // バリデーションエラーがある場合は次へ進めない
        $validator = $this->getNondeliverylValidator($request);
        //バリデーション:エラー 
        if ($validator->fails()) {
            return redirect('/non_delivery')
                ->withInput()
                ->withErrors($validator);
        }

        // いったんSESSIONに保存しておく
        session(['non_delivery_date' => $request->non_delivery_date]);
        session(['gyoumu' => $request->gyoumu]);
        session(['return_reason' => $request->return_reason]);

        // 封筒の配列データを1行をまず定義する
        $value = ['kakitome' => $request->kakitome_number, 'manage' => $request->manage_number,'huutou_qr' => $request->huutou_qr_number];
        // $value2 = ['kakitome' => 12, 'manage' => 13,'huutou_qr' => 14];

        // セッションから2次元配列を取得
        $huutou_data = session('huutous', []);
        $huutou_data[] = $value;//１件分の封筒をSESSIONに保存
        // $huutou_data[] = $value2;

        // セッションに2次元配列を保存
        session()->put('huutous', $huutou_data);
        return redirect('/non_delivery')->with(['message_temporary'=>'仮登録が完了しました。']);


    }

    public function session_delete(Request $request){
        // sessionの削除
        session()->forget('start');
        session()->forget('huutous');
        // session()->forget('count');
        session()->forget('non_delivery_date');
        session()->forget('gyoumu');
        session()->forget('return_reason');

        return redirect('/non_delivery')->with(['message_temporary'=>'一時登録済みのデータを削除しました。']);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $count = count(session('huutous')); // セッションデータの数を取得

        // 1:不着登録テーブルの登録
        $non_delivery = new NonDelivery;
        $non_delivery->date = $request->non_delivery_date;
        $non_delivery->gyoumu_cd = $request->gyoumu;
        $non_delivery->number = $count;
        $non_delivery->return_reason_cd = $request->return_reason;
        $non_delivery->save();  
        

        // 2 3:sessionの登録個数だけ繰り返し
        for ($i = 0; $i < $count; $i++) {

            //2:封筒自体の登録
            $huutous = new Huutou;
            $huutous->non_delivery_date = $request->non_delivery_date;
            $huutous->status_cd = $this->temporary_flag_cd;
            $huutous->kakitome_number = session('huutous')[$i]['kakitome'];
            $huutous->manage_number = session('huutous')[$i]['manage'];
            $huutous->huutou_qr_number = session('huutous')[$i]['huutou_qr'];
            $huutous->save();

            // $last_count = $last_count + 1; //count（封筒テーブルの最後ID）をインクリメント
            // echo $last_count;

            // モデルを使って最後のレコードを取得(最新の封筒CDの値を得る)
            $last_huutous_Record = $huutous::latest('id')->first();//封筒モデルの最後の行を取得
            $last_huutous_Record_id  = $last_huutous_Record->id;

            // モデルを使って最後のレコードを取得(最新の不着登録CDの値を得る)
            $last_non_delivery_Record = $non_delivery::latest('id')->first();//封筒モデルの最後の行を取得
            $last_non_delivery_Record_id  = $last_non_delivery_Record->id;


            // dd($last_non_delivery_Record_id);
            // 3:不着明細テーブルの登録
            $non_delivery_detail = new NonDeliveryDetail;
            $non_delivery_detail->date = $request->non_delivery_date;
            $non_delivery_detail->gyoumu_cd = $request->gyoumu;
            $non_delivery_detail->return_reason_cd = $request->return_reason;
            $non_delivery_detail->non_delivery_cd = $last_non_delivery_Record_id;
            
            $non_delivery_detail->huutou_cd = $last_huutous_Record_id; 
            $non_delivery_detail->save();
        }

        // sessionの削除
        session()->forget('start');
        session()->forget('huutous');
        // session()->forget('count');
        session()->forget('non_delivery_date');
        session()->forget('gyoumu');
        session()->forget('return_reason');


        return redirect('/non_delivery')->with(['count'=>$count,'message'=>'不着登録が完了しました。' ]);
    }

    
    /**
     * Update the specified resource in storage.
     */
    // 不着データ作成ボタンが押されたときにフラグを更新
    public function update(Request $request)
    {
        $today = date('Y-m-d');

        //1:不着登録テーブルのIDを取得  (例：2,3,4,5)
        $today_non_delivery = NonDelivery::orderBy('date','asc')
        ->select('id','creation_flag')
        ->where('creation_flag', '=', 0)
        ->whereDate('date', $today)->get();;

        $count = $today_non_delivery->count();//モデルのデータ数を取得

        // 2:不着登録テーブルIDの不着明細テーブル上に紐づく封筒CDの状態を更新する  
        // 不着登録の１くぎり回数だけ繰り返し(例：2,3,4,5)だと4回繰り返し
        for ($i = 0; $i < $count; $i++) {
            // 2-1:不着明細テーブル上のstatus_cdのステータスを1→2に変更する
            $creation_list = NonDeliveryDetail::where('non_delivery_cd', '=', $today_non_delivery[$i]->id)
            ->where('huutous.status_cd', '=', $this->temporary_flag_cd)
            ->join('huutous','huutous.id','=','non_delivery_detail.huutou_cd')
            ->update(['huutous.status_cd' => $this->order_flag_cd]);

            // 2-2:不着テーブルのcreation_flagを１に変更する
            $update_list = NonDelivery::where('id', '=', $today_non_delivery[$i]->id)
            ->update(['non_delivery.creation_flag' => 1]);

        }
    
        return redirect('/non_delivery_data_creation')->with(['count'=>$count,'message'=>'不着データ生成が完了しました。' ]);
        

    }

     //廃棄完了
     public function update_waste_complete()
     {
         $today = date('Y-m-d');

         $count = $this->non_delivery_detail_waste_controller->count();//モデルのデータ数を取得

         //不着明細テーブルの状態フラグを廃棄完了に変更する
          // 2-1:不着明細テーブル上のstatus_cdのステータス5→6を変更する
          $creation_list = NonDeliveryDetail::where('huutous.status_cd', '=', $this->waste_flag_cd)
          ->join('huutous','huutous.id','=','non_delivery_detail.huutou_cd')
          ->update(['huutous.status_cd' => $this->waste_complete_flag_cd]);
     
         return redirect('/waste')->with(['count'=>$count,'message'=>'廃棄が完了しました。' ]);
         
     }
 
 
     //再発送完了
     public function update_resend_complete()
     {
 
         $today = date('Y-m-d');

         $count = $this->non_delivery_detail_resend_controller->count();//モデルのデータ数を取得

         //不着明細テーブルの状態フラグを再発送完了に変更する
         // 2-1:不着明細テーブル上のstatus_cdのステータス3→4を変更する
         $creation_list = NonDeliveryDetail::where('huutous.status_cd', '=', $this->resend_flag_cd)
         ->join('huutous','huutous.id','=','non_delivery_detail.huutou_cd')
         ->update(['huutous.status_cd' => $this->resend_complete_flag_cd]);
 
         return redirect('/resend')->with(['count'=>$count,'message'=>'再発送が完了しました。' ]);
         
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


   
}
