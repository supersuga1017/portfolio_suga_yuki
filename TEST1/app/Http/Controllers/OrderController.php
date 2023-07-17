<?php

namespace App\Http\Controllers;
use App\Models\NonDelivery;
use App\Models\NonDeliveryDetail;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    private $non_delivery_detail_controller;
    private $order_flag_cd = 2; //指示待ちのフラグCD

    private $waste_flag_cd = 5; //廃棄のフラグCD
    private $resend_flag_cd = 3; //再発送のフラグCD
    private $store_flag_cd = 7; //保管のフラグCD


    public function __construct()
    {
        //指示待ち状態の封筒名声テーブルデータを表示
        $this->non_delivery_detail_controller  =NonDeliveryDetail::orderBy('huutous.status_cd','asc')->orderBy('gyoumu_cd','asc')
        ->orderBy('date','asc')
        ->join('huutous', 'huutous.id', '=', 'huutou_cd')
        ->join('statuses', 'statuses.id', '=', 'huutous.status_cd')
        ->where('statuses.id', '=', $this->order_flag_cd)
        ->get();

    }
    public function index()
    {
        
       
        $non_delivery_detail = $this->non_delivery_detail_controller;

        return view('order',['non_delivery' => $non_delivery_detail]);

    }


    // 指示データ作成
    public function order_complete(){
        // 指示待ちフラグのデータにランダムに再発送、廃棄、保管を設定
        $today = date('Y-m-d');

        $non_delivery_detail = $this->non_delivery_detail_controller;
        $count = $non_delivery_detail->count();//モデルのデータ数を取得


        //指示データにランダムに保管、廃棄、再発送を決定
        $numbers = [$this->resend_flag_cd, $this->waste_flag_cd, $this->store_flag_cd];
        $random = $numbers[array_rand($numbers)]; //現状、乱数で指示決定
        

        //不着明細テーブルの状態フラグを廃棄完了に変更する
         // 2-1:不着明細テーブル上のstatus_cdのステータスを変更する
         $creation_list = NonDeliveryDetail::where('huutous.status_cd', '=', $this->order_flag_cd)
         ->join('huutous','huutous.id','=','non_delivery_detail.huutou_cd')->update(['huutous.status_cd' => $random]);
        
        // foreach ($creation_list as $one_record) {
        //     $one_record->update(['huutous.status_cd' => 3]);
        //  }

        return redirect('/order')->with(['count'=>$count,'message'=>'指示データを反映させました。' ]);
        // return view('order',['non_delivery' => $creation_list]);
    }

}
