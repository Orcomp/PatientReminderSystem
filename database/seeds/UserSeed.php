<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
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
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'remember_token' => '',
            ],
            [
                'id' => 2,
                'first_name' => 'Doctor',
                'last_name' => 'Doctor',
                'email' => 'doctor@doctor.com',
                'password' => bcrypt('password'),
                'remember_token' => '',
            ],
            [
                'id' => 3,
                'first_name' => 'Nurse',
                'last_name' => 'Nurse',
                'email' => 'nurse@nurse.com',
                'password' => bcrypt('password'),
                'remember_token' => '',
            ],
        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}
