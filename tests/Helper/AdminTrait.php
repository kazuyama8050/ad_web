<?php

namespace Tests\Helper;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Trait AdminTrait
{
    public static function insertDefaultAdminData($num, $password = 'test', $authority = 1) {
        $passwordHash = Hash::make($password);
        DB::table('admins')->insert([
            'id' => $num,
            'password' => $passwordHash,
            'email' => "admin$num@email.com",
            'authority' => $authority,
        ]);
    }
}