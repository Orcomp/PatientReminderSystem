<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeed extends Seeder
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
                'patient_id' => 1,
                'user_id' => 2,
                'appointment_time' => Carbon::now()->format(config('app.date_format') . ' H:i'),
                'confirmed_at' => Carbon::now()->format(config('app.date_format') . ' H:i'),
                'created_by_id' => 2,
                'appointment_type_id' => 1
            ],
            [
                'id' => 2,
                'patient_id' => 1,
                'user_id' => 3,
                'appointment_time' => Carbon::now()->format(config('app.date_format') . ' H:i'),
                'created_by_id' => 2,
                'appointment_type_id' => 1
            ],
            [
                'id' => 3,
                'patient_id' => 1,
                'user_id' => 3,
                'appointment_time' => Carbon::now()->format(config('app.date_format') . ' H:i'),
                'created_by_id' => 2,
                'appointment_type_id' => 2
            ],
            [
                'id' => 4,
                'patient_id' => 1,
                'user_id' => 2,
                'appointment_time' => Carbon::now()->addDays(2)->format(config('app.date_format') . ' H:i'),
                'created_by_id' => 2,
                'appointment_type_id' => 1
            ],
            [
                'id' => 5,
                'patient_id' => 1,
                'user_id' => 2,
                'appointment_time' => Carbon::now()->addDays(5)->format(config('app.date_format') . ' H:i'),
                'created_by_id' => 2,
                'appointment_type_id' => 1
            ],
            [
                'id' => 6,
                'patient_id' => 1,
                'user_id' => 2,
                'appointment_time' => Carbon::now()->addDays(1)->format(config('app.date_format') . ' H:i'),
                'created_by_id' => 2,
                'appointment_type_id' => 1
            ],
            [
                'id' => 7,
                'patient_id' => 1,
                'user_id' => 2,
                'appointment_time' => Carbon::now()->addDays(3)->format(config('app.date_format') . ' H:i'),
                'created_by_id' => 2,
                'appointment_type_id' => 1
            ],
        ];

        foreach ($items as $item) {
            \App\Appointment::create($item);
        }
    }
}
