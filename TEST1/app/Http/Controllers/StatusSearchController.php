<?php

namespace App\Http\Controllers;
use App\Models\NonDelivery;
use App\Models\Status;
use App\Models\Gyoumu;

use App\Models\NonDeliveryDetail;

use Illuminate\Http\Request;

class StatusSearchController extends Controller
{
    private $non_delivery_controller;
    private $non_delivery_detail_controller;
    private $status;
    private $gyoumu;
    private $views;  //ビューに送る変数をまとめている連想配列

    public function __construct()
    {
        $today = date('Y-m-d');
        // $this->middleware('auth');


        // モデルを構築
        $this->non_delivery_controller  = NonDelivery::orderBy('date','asc')
        ->where('creation_flag', '=', 0)
        ->join('gyoumu', 'non_delivery.gyoumu_cd', '=', 'gyoumu.id')
        ->whereDate('date', $today)
        ->get();

        $this->status  = Status::get();
        $this->gyoumu  = Gyoumu::get();

        $this->non_delivery_detail_controller  = NonDeliveryDetail::orderBy('huutous.status_cd','asc')->orderBy('gyoumu_cd','asc')
        ->orderBy('date','asc')
        ->join('huutous', 'huutous.id', '=', 'huutou_cd')
        ->join('statuses', 'statuses.id', '=', 'huutous.status_cd');

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $statuses  =  $this->status;
        $non_delivey_detail  = $this->non_delivery_detail_controller->get();

        $views = ['non_delivery_detail'=> $non_delivey_detail,"statuses" => $this->status,"gyoumu" => $this->gyoumu];
        return view('status_search',$views);
    }

     // 状態に合わせて、Statusの背景色を変える
     public function status_color(int $status_id)
     {
         //
        //  $status_id = 1;
         if($status_id == 4 or $status_id ==6){
            return "table__flag-color--last";

         }
        elseif($status_id == 1 or $status_id == 2){
            return "table__flag-color--first";

         }
         elseif($status_id == 3 or $status_id ==5 or $status_id == 7){
            return "table__flag-color--middle";

         }
         else{
            return "table__flag-color";

         }
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //送られた状態CDに応じてモデルの条件を更新する
        $statuses_flag = $request->statuses; //絞り込む状態CDを取得

        if($statuses_flag != 0){//$statuses_flagがすべて以外なら絞り込み
            $non_delivey_detail  = $this->non_delivery_detail_controller->where('statuses.id', '=', $statuses_flag)
            ->get();
        }else{
            $non_delivey_detail  = $this->non_delivery_detail_controller->get();
        }

        return view('status_search',['non_delivery_detail'=> $non_delivey_detail,"statuses" => $this->status]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
