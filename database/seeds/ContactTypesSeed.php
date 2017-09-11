<?php

use Illuminate\Database\Seeder;

class ContactTypesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Patient'],
            ['name' => 'Mother'],
            ['name' => 'Father'],
            ['name' => 'Village Chief'],
            ['name' => 'Educator'],
            ['name' => 'Close Relative'],
            ['name' => 'Distant Relative'],
            ['name' => 'Treating Staff']
        ];

        foreach ($items as $item) {
            \App\ContactType::create($item);
        }
    }
}
