<?php

namespace Tests\Helper;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Trait CategoryTrait
{
    public static function insertDefaultCategoryData($num) {
        DB::table('categories')->insert([
            'id' => $num,
            'name' => "name${num}",
            'level' => 1,
            'parent_id' => 0,
            'floor_price' => 25,
            'average_bid_price' => 25 + $num,
        ]);
    }

    public static function createExpectedCategoryResponse($num) {
        $category = [
            'id' => $num,
            'name' => "name${num}",
            'level' => 1,
            'parent_id' => 0,
            'floor_price' => 25,
            'average_bid_price' => 25 + $num,
        ];

        return $category;
    }
}