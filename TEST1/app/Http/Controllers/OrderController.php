<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        //
       
        
        $today = date('Y-m-d');

        return view('order');
    }
}
