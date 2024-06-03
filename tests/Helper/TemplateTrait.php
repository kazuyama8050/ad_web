<?php

namespace Tests\Helper;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Trait TemplateTrait
{
    public static function insertDefaultTemplateData($num, $advertiserId) {
        DB::table('templates')->insert([
            'id' => $num,
            'advertiser_id' => $advertiserId,
            'url' => "https://testtest$num",
            'text' => "aaaaaaiiiiiiuuuuuああああ$num",
            'image_path' => "storage/uploads/advertisement/$advertiserId/$advertiserId-11111.png",
        ]);
    }

    public static function createExpectedTemplateResponse($num, $advertiserId) {
        $template = [
            'id' => $num,
            'advertiserId' => $advertiserId,
            'url' => "https://testtest$num",
            'bannerText' => "aaaaaaiiiiiiuuuuuああああ$num",
            'imagePath' => "storage/uploads/advertisement/$advertiserId/$advertiserId-11111.png",
        ];

        return $template;
    }
}