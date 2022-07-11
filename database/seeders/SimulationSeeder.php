<?php

namespace Database\Seeders;

use App\Models\Simulation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SimulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Simulation::create([
            'id_user' => 1,
            'pretended_value' => 0.0,
            'pretended_deadline' => 0.0,
            'increased_value' => 0.0,
            'saved' => true,
        ]);
        Simulation::create([
            'id_user' => 2,
            'pretended_value' => 0.0,
            'pretended_deadline' => 0.0,
            'increased_value' => 0.0,
            'saved' => true,
        ]);
    }
}
