<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //アフィリエイター登録審査
        Schema::create('user_examinations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('phone')->nullable(false);
            $table->string('category')->nullable(false);
            $table->string('site_domein')->nullable(false);
            $table->smallInteger('review_flag')->nullable(false);  //未審査：0、審査OK：1、審査NG：2
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //アフィリエイター
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('examination_id');
            $table->string('password')->nullable(false);
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('phone')->nullable(false);
            $table->string('zipcode')->nullable(true);
            $table->string('address')->nullable(true);
            $table->smallInteger('payment_way')->nullable(false)->default(0);  //前払い：0 後払い：1
            $table->integer('budget')->nullable(false)->default(0);
            $table->foreign('examination_id') 
                  ->references('id') 
                  ->on('user_examinations') 
                  ->onDelete('cascade');
            $table->smallInteger('is_stopped')->nullable(false);  //アカウント運用中：0、アカウント停止中：1
            $table->smallInteger('is_retire')->nullable(false);  //未退会：0、退会済み：1
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        
        //アフィリエイターお金周り
        Schema::create('user_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                  ->references('id') 
                  ->on('users')
                  ->onDelete('cascade');
            $table->string('bank_name')->nullable(false);
            $table->string('bank_number')->nullable(false);
            $table->string('bank_apply_name')->nullable(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        
        //アフィリエイター利用明細
        Schema::create('user_payment_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                  ->references('id') 
                  ->on('users')
                  ->onDelete('cascade');
            $table->string('title')->nullable(false);
            $table->longText('texts')->nullable();
            $table->integer('balance')->nullable(false);  //この時点の残高
            $table->integer('price')->nullable(false);  //動いた金額
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //広告主
        Schema::create('advertisers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password')->nullable(false);
            $table->string('company_name')->nullable(false);
            $table->string('company_zipcode')->nullable(false);
            $table->string('company_address')->nullable(false);
            $table->string('company_site_url')->nullable(false);
            $table->string('manager_first_name')->nullable(false);
            $table->string('manager_last_name')->nullable(false);
            $table->string('manager_email')->nullable(false);
            $table->string('manager_phone')->nullable(false);
            $table->smallInteger('is_stopped')->nullable(false);  //アカウント運用中：0、アカウント停止中：1
            $table->smallInteger('is_retire')->nullable(false);  //未退会：0、退会済み：1
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //広告主　お金周り
        Schema::create('advertiser_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('advertiser_id');
            $table->foreign('advertiser_id')
                  ->references('id') 
                  ->on('advertisers')
                  ->onDelete('cascade');
            $table->string('bank_name')->nullable(false);
            $table->string('bank_number')->nullable(false);
            $table->string('bank_apply_name')->nullable(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //広告主利用明細
        Schema::create('advertiser_payment_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('advertiser_id');
            $table->foreign('advertiser_id')
                  ->references('id') 
                  ->on('advertisers')
                  ->onDelete('cascade');
            $table->string('title')->nullable(false);
            $table->longText('texts')->nullable();
            $table->integer('balance')->nullable(false);  //この時点の残高
            $table->integer('price')->nullable(false);  //動いた金額
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //管理者
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password')->nullable(false);
            $table->string('email')->nullable(false);
            $table->smallInteger('authority')->nullable(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //管理者権限
        Schema::create('authorities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //カテゴリ
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(false);
            $table->smallInteger('level')->nullable(false);
            $table->smallInteger('parent_id')->nullable(false);  //最上位階層の場合は0
            $table->integer('floor_price')->nullable();
            $table->float('average_bid_price')->nullable();
            $table->smallInteger('is_delete')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //表示広告テンプレート
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advertiser_id')->unsigned();
            $table->foreign('advertiser_id')
                  ->references('id') 
                  ->on('advertisers')
                  ->onDelete('cascade');
            $table->string('url')->nullable(false);
            $table->longText('text')->nullable(false);
            $table->string('image_path')->nullable(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //広告情報
        Schema::create('advertisements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advertiser_id')->unsigned();
            $table->foreign('advertiser_id')
                  ->references('id') 
                  ->on('advertisers')
                  ->onDelete('cascade');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                  ->references('id') 
                  ->on('categories');
            $table->unsignedInteger('template_id');
            $table->foreign('template_id')
                  ->references('id') 
                  ->on('templates');
            $table->string('name')->nullable(false);
            $table->integer('bid_price')->nullable(false);
            $table->smallInteger('is_stopped')->nullable(false);  //配信中：0、配信停止中：1
            $table->smallInteger('review_flag')->nullable(false);  //広告未審査：0、広告審査OK：1、広告審査NG：2
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //アフィリエイターと管理者のメール管理
        Schema::create('user_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id') 
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedInteger('admin_id');
            $table->foreign('admin_id')
                ->references('id') 
                ->on('admins')
                ->onDelete('cascade');
            $table->longText('text')->nullable(false);
            $table->smallInteger('from')->nullable(false);  //admin or user
            $table->dateTime('last_message_datetime')->nullable();
            $table->smallInteger('is_read')->nullable(false);  //未読：0、既読：1
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        //広告主と管理者のメール管理
        Schema::create('advertiser_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('advertiser_id');
            $table->foreign('advertiser_id')
                  ->references('id') 
                  ->on('advertisers')
                  ->onDelete('cascade');
            $table->unsignedInteger('admin_id');
            $table->foreign('admin_id')
                  ->references('id') 
                  ->on('admins')
                  ->onDelete('cascade');
            $table->longText('text')->nullable(false);
            $table->smallInteger('from')->nullable(false);    //admin or advertiser
            $table->dateTime('last_message_datetime')->nullable();
            $table->smallInteger('is_read')->nullable(false);  //未読：0、既読：1
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('user_examinations');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_bills');
        Schema::dropIfExists('user_payment_history');
        Schema::dropIfExists('advertisers');
        Schema::dropIfExists('advertiser_bills');
        Schema::dropIfExists('advertiser_payment_history');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('authorities');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('templates');
        Schema::dropIfExists('advertisements');
        Schema::dropIfExists('user_messages');
        Schema::dropIfExists('advertiser_messages');
        Schema::enableForeignKeyConstraints();
    }
}
