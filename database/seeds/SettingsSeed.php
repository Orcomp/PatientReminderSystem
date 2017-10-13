<?php

use Illuminate\Database\Seeder;

class SettingsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['key' => 'first_reminder', 'value' => 5],
            ['key' => 'second_reminder', 'value' => 2],
            ['key' => 'look_ahead_window', 'value' => 21]
        ];

        foreach ($items as $item) {
            \App\Settings::create($item);
        }
    }
}
