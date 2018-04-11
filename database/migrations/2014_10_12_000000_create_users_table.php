<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert(
            array(
                'id' => 1,
                'name' => 'Jamahl',
                'email' => 'jamahlmd@gmail.com',
                'password' => bcrypt('test123')
            )
        );

        DB::table('users')->insert(
            array(
                'id' => 2,
                'name' => 'tester',
                'email' => 'test@test.nl',
                'password' => bcrypt('test123')
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
