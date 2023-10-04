<?php

use Illuminate\Database\Seeder;

class InstitutionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'database/seeders/raw/institution.sql';
        DB::unprepared(file_get_contents($path));
    }
}
