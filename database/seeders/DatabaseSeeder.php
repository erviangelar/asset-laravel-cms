<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\seeders\RolesSeeder;
use Database\seeders\UsersSeeder;
use Database\seeders\MenusSeeder;
use Database\seeders\InstitutionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(MenusSeeder::class);
        $this->call(InstitutionSeeder::class);
    }
}
