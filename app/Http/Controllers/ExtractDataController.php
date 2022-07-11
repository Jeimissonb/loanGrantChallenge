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
        return view('dados');
    }
    public function BackPage()
    {
        return redirect('/resultado');
    }

    public function DownloadData()
    {
        $user = User::all();


        // dd(isset($user->id) ? $user->id : 500);
        // $simulations = Simulation::where('id_user', $user->id)->get();
        $simulations = Simulation::all();


        // dd($simulations);

        // $users = Friends::where('accepted', false)->where('target_user', $userId)->get();

        $pdf = PDF::loadView('mail.allData', compact('user', 'simulations'));
        return $pdf->setPaper('a4')->stream('kbrChallenge.pdf');
    }
}
