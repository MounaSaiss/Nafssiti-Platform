<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function userGestion(){
        return view('admin.userGestion');
    }
    public function appointmentsGestion(){
        return view('admin.appointmentsGestion');
    }
}

