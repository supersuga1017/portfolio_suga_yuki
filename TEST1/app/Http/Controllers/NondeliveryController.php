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
    //コンストラクタ （このクラスが呼ばれたら最初に処理をする）

    public function __construct()
    {
        $today = date('Y-m-d');
        // $this->middleware('auth');

        $this->non_delivery_controller  = NonDelivery::orderBy('gyoumu_cd','asc')
        ->join('gyoumu','gyoumu.id','=','non_delivery.gyoumu_cd')
        ->whereDate('date', $today)
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
                ->whereDate('date', $today)
                ->get();

        //$today_label_number_db[0]->all_numberがNULLでなければ、$today_label_numberに代入
        // NULLなら0を代入
        $today_non_delivery_number = $non_delivery_sum[0]->count ?? 0;
        return view('non_delivery_data_creation',['non_delivery' => $non_delivery,'today_non_delivery_number' => $today_non_delivery_number]);

    }
    //バリデーション
    public function getNondeliverylValidator(Request $request) {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'kakitome_number' => 'required | min:1 | max:10',
            'manage_number' => 'required | min:1 | max:10',
            'huutou_qr_number' => 'required | min:1 | max:10',
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
        return redirect('/non_delivery')->with(['message_temporary'=>'一時登録が完了しました。']);


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
            $huutous->status_cd = 6;
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
            $last_non_delivery_Record_id  = $last_non_delivery_Record;

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

    /**
     * Update the specified resource in storage.
     */
    // 不着データ作成ボタンが押されたときにフラグを更新
    public function update(Request $request)
    {
        //
        dd($this->non_delivery_controller);

        // 不着明細テーブル上に紐づく封筒CDの状態を更新する
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
