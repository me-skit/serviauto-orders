<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Client::factory(25)->create();
        
        $this->call(UserSeeder::class);

        $this->call(ItemSeeder::class);
    }
}
