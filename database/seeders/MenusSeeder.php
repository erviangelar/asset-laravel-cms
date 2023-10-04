<?php

use Illuminate\Database\Seeder;

class MenusSeederInitial extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/seeders/raw/menus.sql';
        DB::unprepared(file_get_contents($path));
    }
}
