<?php

namespace App\Http\Controllers;

use App\Models\Simulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtractDataController extends Controller
{
    public function ExtractData()
    {
        return view('dados');
    }
    public function BackPage()
    {
        return redirect('/resultado');
    }
}
