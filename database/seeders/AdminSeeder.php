<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $password = 'admin';
        $passwordHash = Hash::make($password);
        DB::table('admins')->insert([
            'password' => $passwordHash,
            'email' => 'test@gmail.com',
            'authority' => 1,
        ]);

    }
}
