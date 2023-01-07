<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('zipcode')->nullable(true)->change();
            $table->string('address')->nullable(true)->change();
            $table->smallInteger('payment_way')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('zipcode')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->smallInteger('payment_way')->nullable(false)->change();
        });
    }
}
