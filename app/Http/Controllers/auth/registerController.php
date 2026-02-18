<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class registerController extends Controller
{
    public function showRegistrationForm (){
        return view('auth.register.patient');
    }
    public function showPsychologueRegistrationForm (){
        return view('auth.register.psychologue');
    }
}
