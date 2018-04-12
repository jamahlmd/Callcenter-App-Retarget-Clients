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
            $table->integer('status')->default(0);
            $table->text('opmerking')->nullable();
            // 0 Frisse Lead
            // 1 Terug bel
            // 2 Reject
            // 3 Sale
            // 4 Trash
            // 5 Niet opgenomen
            // 6 Frans
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
