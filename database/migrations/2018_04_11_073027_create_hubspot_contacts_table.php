<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHubspotContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hubspot_contacts', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('StreetAddress')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('bestelGeschiedenis')->nullable();
            $table->string('Orderdatum')->nullable();
            $table->text('Totalproducts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hubspot_contacts');
    }
}
