<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view("patient.dashboard");
    }
    public function reservation(){
        return view("patient.reservation");
    }
    public function rendezVous(){
        return view("patient.rendezVous");
    }
    public function profil(){
        return view("patient.profil");
    }
}
