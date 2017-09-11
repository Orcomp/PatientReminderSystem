<?php

use Illuminate\Database\Seeder;

class AppointmentTypesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Face to Face'],
            ['name' => 'Over the Phone'],
        ];

        foreach ($items as $item) {
            \App\AppointmentType::create($item);
        }
    }
}
