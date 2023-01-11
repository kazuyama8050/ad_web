<?php

namespace Tests\Helper;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Trait UserTrait
{
    public static function insertDefaultUserData($num, $password = 'test', $isStopped = 0, $isRetire = 0) {
        $passwordHash = Hash::make($password);
        DB::table('users')->insert([
            'id' => $num,
            'examination_id' => $num,
            'last_name' => "lastName$num",
            'first_name' => "firstName$num",
            'password' => $passwordHash,
            'phone' => "080-0808-080$num",
            'email' => "validate$num@email.com",
            'zipcode' => "000-000$num",
            'address' => "東京都日野市$num",
            'payment_way' => 0,
            'budget' => 0,
            'is_stopped' => $isStopped,
            'is_retire' => $isRetire,
        ]);
    }
}