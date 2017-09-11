<?php

use Illuminate\Database\Seeder;

class CountrySeed extends Seeder
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
                'name' => 'Senegal',
            ],
        ];

        foreach ($items as $item) {
            \App\Country::create($item);
        }
    }
}
