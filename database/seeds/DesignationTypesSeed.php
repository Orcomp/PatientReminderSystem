<?php

use Illuminate\Database\Seeder;

class DesignationTypesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Mr'],
            ['name' => 'Mrs'],
            ['name' => 'Master'],
            ['name' => 'Ms'],
            ['name' => 'Dr'],
            ['name' => 'Chief']
        ];

        foreach ($items as $item) {
            \App\DesignationType::create($item);
        }
    }
}
