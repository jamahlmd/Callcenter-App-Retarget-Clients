<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketinglistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketinglists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('product');
            $table->string('agent')->nullable();
            $table->integer('sales')->default(0);
            $table->integer('rejects')->default(0);
            $table->timestamps();
        });

        DB::table('marketinglists')->insert(
            array(
                'id' => 1,
                'name' => 'TestLijst',
                'product' => 'Goji-Cream'
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
        Schema::dropIfExists('marketinglists');
    }
}
