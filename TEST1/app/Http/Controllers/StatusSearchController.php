<?php

namespace App\Http\Controllers;
use App\Models\NonDelivery;
use App\Models\Status;
use App\Models\NonDeliveryDetail;

use Illuminate\Http\Request;

class StatusSearchController extends Controller
{
    private $non_delivery_controller;

    public function __construct()
    {
        $today = date('Y-m-d');
        // $this->middleware('auth');

        $this->non_delivery_controller  = NonDelivery::orderBy('date','asc')
        ->where('creation_flag', '=', 0)
        ->join('gyoumu', 'non_delivery.gyoumu_cd', '=', 'gyoumu.id')
        ->whereDate('date', $today)
        ->get();

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $status  = Status::get();
        // dd($status);
        $non_delivey_detail  = NonDeliveryDetail::orderBy('huutous.status_cd','asc')->orderBy('gyoumu_cd','asc')
        ->orderBy('date','asc')
        ->join('huutous', 'huutous.id', '=', 'huutou_cd')
        ->join('statuses', 'statuses.id', '=', 'huutous.status_cd')
        ->get();

        // dd($non_delivey_detail);

        return view('status_search',['non_delivery'=> $non_delivey_detail,"status"=>$status]);
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
