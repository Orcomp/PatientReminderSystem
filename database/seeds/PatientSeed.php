<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PatientSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'id' => 1,
                'first_name' => 'Patient 01',
                'last_name' => 'Patient 01',
                'gender' => 'Male',
                'birth_date' => Carbon::now()->toDateString(),
                'schooled' => 1,
            ],
            [
                'id' => 2,
                'first_name' => 'Patient 02',
                'last_name' => 'Patient 02',
                'gender' => 'Female',
                'birth_date' => Carbon::now()->toDateString(),
                'schooled' => 1,
            ],
        ];

        foreach ($items as $item) {
            \App\Patient::create($item);
        }
    }
}
