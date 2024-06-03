<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\Helper\AdminLoginTrait;

class GetUserNoRegisteredTest extends TestCase
{
    use RefreshDatabase;
    use AdminLoginTrait;
    public function setup(): void {
        parent::setup();
        $this->insertNecessaryTestData();
    }

    public function insertNecessaryTestData() {
        DB::table('user_examinations')->insert([
            'last_name' => 'lastName1',
            'first_name' => 'firstName1',
            'phone' => '080-0808-0801',
            'email' => 'validate1@email.com',
            'category' => '金融',
            'site_domein' => 'aaaaa1.com',
            'review_flag' => 0,
        ]);
        DB::table('user_examinations')->insert([
            'last_name' => 'lastName2',
            'first_name' => 'firstName2',
            'phone' => '080-0808-0802',
            'email' => 'validate2@email.com',
            'category' => '金融',
            'site_domein' => 'aaaaa2.com',
            'review_flag' => 0,
        ]);
        DB::table('user_examinations')->insert([
            'last_name' => 'lastName3',
            'first_name' => 'firstName3',
            'phone' => '080-0808-0830',
            'email' => 'validate3@email.com',
            'category' => '金融',
            'site_domein' => 'aaaaa3.com',
            'review_flag' => 1,
        ]);
        DB::table('user_examinations')->insert([
            'last_name' => 'lastName4',
            'first_name' => 'firstName4',
            'phone' => '080-0808-0840',
            'email' => 'validate4@email.com',
            'category' => '金融',
            'site_domein' => 'aaaaa4.com',
            'review_flag' => 2,
        ]);
        
    }
    /**
     * Summary of test_正常
     * @return void
     */
    public function test_正常()
    {
        AdminLoginTrait::adminLogin();
        $response = $this->get('/api/user-no-registered');
        $response->assertStatus(200);

        $responseBody = $response->decodeResponseJson();

        $response->assertJsonFragment([
            'lastName' => 'lastName1',
            'firstName' => 'firstName1',
            'phone' => '080-0808-0801',
            'email' => 'validate1@email.com',
            'siteDomein' => 'aaaaa1.com',
            'category' => '金融',
        ]);
        $response->assertJsonFragment([
            'lastName' => 'lastName2',
            'firstName' => 'firstName2',
            'phone' => '080-0808-0802',
            'email' => 'validate2@email.com',
            'siteDomein' => 'aaaaa2.com',
            'category' => '金融',
        ]);

        session()->flush();

    }
}
