<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
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
        $user = User::create([
          'name' => "Test",
          'email' => "test@gmail.com",
          'password' => Hash::make("Jix9NG!Dg699QLa"),
        ]);
        $profile = Profile::create([
          "user_id" => $user->id,
          "username"=> $user->name,
          "picture" => $user->getGravatar(),
        ]);
    }
}
