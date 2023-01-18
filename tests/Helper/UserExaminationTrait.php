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
            'phone' => "080-0808-080$num",
            'email' => "validate$num@email.com",
            'category' => "金融",
            'site_domein' => "aaaaa$num.com",
            'review_flag' => $reviewFlag,
        ]);
    }
}