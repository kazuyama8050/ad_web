<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertDefaultCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // insert default categories 
        \DB::table('categories')->insert([
            [
                'name' => '金融',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 40,
            ],
            [
                'name' => '旅行',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
            ],
            [
                'name' => 'ショッピング・オークション',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
            ],
            [
                'name' => '就職・転職',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 30,
            ],
            [
                'name' => 'PC・家電',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
            ],
            [
                'name' => '通信・キャリア',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
            ],
            [
                'name' => 'エンターテイメント',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
            ],
            [
                'name' => 'ふるさと納税',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
            ],
            [
                'name' => '美容・コスメ',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
            ],
            [
                'name' => '飲食・グルメ',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
            ],
            [
                'name' => 'その他',
                'level' => 1,
                'parent_id' => 0,
                'floor_price' => 25,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
