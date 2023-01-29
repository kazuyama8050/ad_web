<?php

namespace Tests\Helper;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Trait AdvertisementTrait
{
    public static function insertDefaultAdvertisementData($num, $advertiserId, $categoryId, $templateId, $price = 50, $isStopped = 0, $reviewFlag = 1) {
        DB::table('categories')->insert([
            'id' => $num,
            'advertiser_id' => $advertiserId,
            'category_id' => $categoryId,
            'template_id' => $templateId,
            'name' => "name${num}",
            'bid_price' => $price,
            'is_stopped' => $isStopped,
            'review_flag' => $reviewFlag,
        ]);
    }

    public static function createExpectedAdvertisementResponse($num, $advertiserId, $categoryId, $templateId, $price = 50, $isStopped = 0, $reviewFlag = 1) {
        $advertisement = [
            'id' => $num,
            'advertiser_id' => $advertiserId,
            'category_id' => $categoryId,
            'template_id' => $templateId,
            'name' => "name${num}",
            'bid_price' => $price,
            'is_stopped' => $isStopped,
            'review_flag' => $reviewFlag,
        ];

        return $advertisement;
    }
}