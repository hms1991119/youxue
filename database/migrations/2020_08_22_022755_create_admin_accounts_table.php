<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password');
            $table->string('realname');
            $table->tinyInteger('role');
            $table->char('phone',11);
            $table->bigInteger('last_login_time');
            $table->tinyInteger('enabled');
            //更新时间、创建时间
            $table->timestamps();
        });

        /*Schema::table('admin_accounts', function (Blueprint $table) {
            $table->string('role')->nullable()->change();
            $table->char('phone',11)->nullable()->change();
        });*/

        Schema::table('users', function ($table) {
            $table->string('api_token', 80)->after('password')
                ->unique()
                ->nullable()
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_accounts');
    }
}
