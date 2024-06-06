<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
        return view('index');
    }
    public function paymenthistory(){
        return view('paymenthistory');       
    }
    public function paymentsuccess(){
        return view('paymentsuccess');       
    }
    public function paymentcancel(){
        return view('paymentcancel');       
    }
}
