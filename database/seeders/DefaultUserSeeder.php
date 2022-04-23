<?php

namespace Database\Seeders;

use App\Constants\RoleTypes;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "admin";
        $user->surname = "admin";
        $user->email = "admin@skills.lv";
        $user->password = Hash::make(config('skills.auth.default_pass'));
        $user->role = RoleTypes::ADMIN;
        $user->save();

        $user = new User();
        $user->name = "client";
        $user->surname = "client";
        $user->email = "client@skills.lv";
        $user->password = Hash::make(config('skills.auth.default_pass'));
        $user->role = RoleTypes::CLIENT;
        $user->save();

        $user = new User();
        $user->name = "courier";
        $user->surname = "courier";
        $user->email = "courier@skills.lv";
        $user->password = Hash::make(config('skills.auth.default_pass'));
        $user->role = RoleTypes::COURIER;
        $user->save();
    }
}
