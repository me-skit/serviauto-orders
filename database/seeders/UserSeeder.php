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
        $user->name = "John1";
        $user->email = "john1.doe@mail.com";
        $user->password = Hash::make("ThePa5sw0rd");
        $user->save();

        $user = new User();
        $user->name = "John2";
        $user->email = "john2.doe@mail.com";
        $user->password = Hash::make("ThePa5sw0rd");
        $user->save();
    }
}
