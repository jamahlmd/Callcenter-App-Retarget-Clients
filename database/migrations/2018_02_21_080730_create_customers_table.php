<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marketinglist_id')->nullable();
            $table->string('name');
            $table->string('e-mail')->nullable();
            $table->string('telefoon')->nullable();
            $table->string('mobiel')->nullable();
            $table->string('status')->default('Niet gebeld');
            $table->string('agent')->nullable();
            $table->dateTime('afspraak')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
