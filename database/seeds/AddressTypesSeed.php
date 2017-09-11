<?php

use Illuminate\Database\Seeder;

class AddressTypesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Home'],
            ['name' => 'Work'],
            ['name' => 'Other'],
        ];

        foreach ($items as $item) {
            \App\AddressType::create($item);
        }
    }
}
