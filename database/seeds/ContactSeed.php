<?php

use Illuminate\Database\Seeder;

class ContactSeed extends Seeder
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
                'mobile_number' => '333-333-3333',
                'phone_number' => '433-333-3334',
                'email' => 'patient01@patient.com',
                'contact_type_id' => 2,
                'designation_type_id' => 1,
                'patient_id' => 1,
                'is_primary' => 1
            ],
            [
                'id' => 2,
                'first_name' => 'Patient 02',
                'last_name' => 'Patient 02',
                'mobile_number' => '555-555-5555',
                'phone_number' => '655-555-5556',
                'email' => 'patient02@patient.com',
                'contact_type_id' => 3,
                'designation_type_id' => 2,
                'patient_id' => 2,
                'is_primary' => 1
            ],
        ];

        foreach ($items as $item) {
            \App\Contact::create($item);
        }
    }
}
