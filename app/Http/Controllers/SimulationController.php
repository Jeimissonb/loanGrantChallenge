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
        $months = $request->input('pretended_deadline');
        $value = $request->input('pretended_value');
        $increasedValue = null;
        $installmentValue = null;

        switch ($months) {
            case '6':
                $increasedValue = (float)$value + ((float)$value  * 0.179);
                $installmentValue = $increasedValue / 6;
                break;

            case '12':
                $increasedValue = (float)$value + ((float)$value  * 0.094);
                $installmentValue = $increasedValue / 12;
                break;

            case '24':
                $increasedValue = (float)$value + ((float)$value  * 0.052);
                $installmentValue = $increasedValue / 24;
                break;

            case '36':
                $increasedValue = (float)$value + ((float)$value  * 0.037);
                $installmentValue = $increasedValue / 36;
                break;
        }

        
    }
}
