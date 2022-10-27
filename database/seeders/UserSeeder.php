<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Meme";
        $user->email = "meme_es@hotmail.com";
        $user->password = Hash::make("Admin*123");
        $user->save();

        $user = new User();
        $user->name = "Oswald";
        $user->email = "serviautogt@gmail.com";
        $user->password = Hash::make("Admin*123");
        $user->save();
    }
}
