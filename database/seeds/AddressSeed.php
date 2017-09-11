<?php

use Illuminate\Database\Seeder;

class AddressSeed extends Seeder
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
                'contact_id' => 1,
                'address_type_id' => 1
            ],
            [
                'id' => 2,
                'contact_id' => 2,
                'address_type_id' => 1
            ],
        ];

        foreach ($items as $item) {
            \App\Address::create($item);
        }
    }
}
