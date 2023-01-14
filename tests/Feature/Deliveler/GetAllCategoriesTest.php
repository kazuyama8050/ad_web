<?php

namespace Tests\Feature\Deliveler;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;

class GetAllCategoriesTest extends TestCase
{
    use RefreshDatabase;
    public function setup(): void {
        parent::setup();
        DB::table('categories')->delete();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData() {
        for ($i=1;$i<=10;$i++) {
            DB::table('categories')->insert([
                'id' => $i,
                'name' => "name${i}",
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
                'average_bid_price' => 25 + $i,
            ]);
        }
        for ($i=1;$i<=10;$i++) {
            DB::table('categories')->insert([
                'id' => 10 + $i,
                'name' => "name${i}_level2",
                'level' => 2,
                'parent_id' => $i,
                'floor_price' => 35,
                'average_bid_price' => 35 + $i,
            ]);
        }
        
        for ($i=1;$i<=10;$i++) {
            DB::table('categories')->insert([
                'id' => 20 + $i,
                'name' => "name${i}_level3",
                'level' => 3,
                'parent_id' => 11,
                'floor_price' => 45,
                'average_bid_price' => 45 + $i,
            ]);
        }
        
    }
    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        $response = $this->get('/api/all-categories');
        $responseBody = $response->decodeResponseJson();

        $responseExpected = [];
        for ($i = 1; $i <= 10;$i++) {
            $responseExpected['level1'][$i]['id'] = $i;
            $responseExpected['level1'][$i]['name'] = "name{$i}";
            $responseExpected['level1'][$i]['level'] = 1;
            $responseExpected['level1'][$i]['parentId'] = 0;
            $responseExpected['level1'][$i]['floorPrice'] = 25;
            $responseExpected['level1'][$i]['averageBidPrice'] = 25 + $i;
        }
        for ($i = 1; $i <= 10;$i++) {
            $responseExpected['level2'][10+$i]['id'] = 10 + $i;
            $responseExpected['level2'][10+$i]['name'] = "name${i}_level2";
            $responseExpected['level2'][10+$i]['level'] = 2;
            $responseExpected['level2'][10+$i]['parentId'] = $i;
            $responseExpected['level2'][10+$i]['floorPrice'] = 35;
            $responseExpected['level2'][10+$i]['averageBidPrice'] = 35 + $i;
        }
        for ($i = 1; $i <= 10;$i++) {
            $responseExpected['level3'][20+$i]['id'] = 20 + $i;
            $responseExpected['level3'][20+$i]['name'] = "name${i}_level3";
            $responseExpected['level3'][20+$i]['level'] = 3;
            $responseExpected['level3'][20+$i]['parentId'] = 11;
            $responseExpected['level3'][20+$i]['floorPrice'] = 45;
            $responseExpected['level3'][20+$i]['averageBidPrice'] = 45 + $i;
        }
        $response->assertJsonFragment($responseExpected);

        $response->assertStatus(200);
    }
}
