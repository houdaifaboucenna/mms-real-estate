<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Profile;
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
        $user = User::firstOrCreate([
            'email' => 'test@gmail.com',
        ], [
            'name' => 'Test',
            'password' => Hash::make('Jix9NG!Dg699QLa'),
        ]);
        $profile = Profile::firstOrCreate([
            'user_id' => $user->id,
        ], [
            'username' => $user->name,
            'picture' => getGravatar($user->email),
        ]);

        $user->assignRole(RoleEnum::ADMIN);
    }
}
