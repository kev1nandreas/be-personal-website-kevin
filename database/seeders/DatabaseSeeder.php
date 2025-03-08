<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::create([
            'id' => '0c35f54a-5917-4c98-b8e9-29110caac8a4',
            'name' => 'Kevin Andreas',
            'password' => bcrypt('password'),
            'email' => 'kevin.andreascn@gmail.com'
        ]);

        Link::factory(10)->create();
    }
}
