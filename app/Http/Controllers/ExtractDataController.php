<?php

namespace App\Http\Controllers;

use App\Models\Simulation;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtractDataController extends Controller
{
    public function ExtractData()
    {
        $simulations = Simulation::all();
        $totalSimulations = count($simulations);
        $totalValueSimulations = null;

        foreach ($simulations as $e) {

            $totalValueSimulations = $totalValueSimulations + $e['increased_value'];
        }

        return view('dados', compact('totalValueSimulations', 'totalSimulations'));
    }

    public function BackPage()
    {
        return redirect('/resultado');
    }

    public function DownloadData()
    {
        $user = User::all();
        $simulations = Simulation::all();
        $pdf = PDF::loadView('mail.allData', compact('user', 'simulations'));
        return $pdf->setPaper('a4')->stream('kbrChallenge.pdf');
    }
}
