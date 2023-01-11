<?php

namespace Tests\Helper;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;

Trait UserExaminationTrait
{
    public static function insertDefaultUserExaminationData($num, $reviewFlag = 1) {
        DB::table('user_examinations')->insert([
            'id' => $num,
            'last_name' => "lastName$num",
            'first_name' => "firstName$num",
            'phone' => "080-0808-0801$num",
            'email' => "validate1@email.com$num",
            'category' => "金融",
            'site_domein' => "aaaaa$num.com",
            'review_flag' => $reviewFlag,
        ]);
    }
}