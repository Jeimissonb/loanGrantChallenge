<?php

namespace App\Http\Controllers;

use App\Models\Simulation;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    public function SendCalculate(Request $request)
    {
    }

    public function Calculate(Request $request)
    {
        dd($request->input('pretended_value'));
    }
}
