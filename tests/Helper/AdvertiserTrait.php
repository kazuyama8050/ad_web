<?php

namespace Tests\Helper;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Trait AdvertiserTrait
{
    public static function insertDefaultAdvertiserData($num, $password = 'test', $paymentWay = 0, $budget = 0, $isStopped = 0, $isRetire = 0) {
        $passwordHash = Hash::make($password);
        DB::table('advertisers')->insert([
            'id' => $num,
            'password' => $passwordHash,
            'store_account' => "store$num",
            'company_name' => "companyname$num",
            'company_zipcode' => "000-000$num",
            'company_address' => "companyAddress$num",
            'company_site_url' => "https://site_url$num",
            'manager_last_name' => "lastName$num",
            'manager_first_name' => "firstName$num",
            'manager_phone' => "080-0808-080$num",
            'manager_email' => "advertiser$num@email.com",
            'payment_way' => $paymentWay,
            'budget' => $budget,
            'is_stopped' => $isStopped,
            'is_retire' => $isRetire,
        ]);
    }
}