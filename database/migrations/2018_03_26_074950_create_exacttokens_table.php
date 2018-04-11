<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExacttokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exacttokens', function (Blueprint $table) {
            $table->increments('id');
            $table->text('accesstoken')->nullable();
            $table->text('refreshtoken')->nullable();
            $table->string('division')->nullable();
            $table->timestamps();
        });

        DB::table('exacttokens')->insert(
            array(
                'id' => 1
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
        Schema::dropIfExists('exacttokens');
    }
}
