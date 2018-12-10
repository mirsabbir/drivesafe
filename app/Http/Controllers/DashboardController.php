<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        if(\Auth::user()->userable_type=='App\Admin'){
            return view('dashboard.admin');
        }
        if(\Auth::user()->userable_type=='App\Driver'){
            return view('dashboard.driver');
        }
        if(\Auth::user()->userable_type=='App\Reporter'){
            return view('dashboard.reporter');
        }
    }
    

}
