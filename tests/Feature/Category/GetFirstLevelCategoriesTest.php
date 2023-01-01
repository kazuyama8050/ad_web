<?php

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;

class GetFirstLevelCategoriesTest extends TestCase
{
    use RefreshDatabase;
    public function setup(): void {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData() {
        for ($i=0;$i<=10;$i++) {
            DB::table('categories')->insert([
                'name' => "name${i}",
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
                'average_bid_price' => 25 + $i,
            ]);
        }
        DB::table('categories')->insert([
            'name' => 'name_level2',
            'level' => 2,
            'parent_id' => 1,
            'floor_price' => 24,
            'average_bid_price' => 34,
        ]);
        
    }
    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        $response = $this->get('/api/first-level-categories');
        $responseBody = $response->decodeResponseJson();
        for ($i=0;$i<=10;$i++) {
            $response->assertJsonFragment([
                'name' => "name${i}",
                'level' => 1,
                'parentId' => 0,
                'floorPrice' => 25,
                'averageBidPrice' => 25 + $i,
            ]);
        }

        $response->assertStatus(200);
    }
}
