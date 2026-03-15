<?php

namespace App\Http\Controllers\psychologue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view("psychologue.dashboard");
    }
    public function profil(){
        return view("psychologue.profil");
    }
    public function disponabilite(){
        return view("psychologue.disponabilite");
    }
    public function rendezVous(){
        return view("psychologue.rendezVous");
    }
    public function historique(){
        return view("psychologue.historique");
    }
}
