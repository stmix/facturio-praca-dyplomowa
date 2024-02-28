<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->text('client_name');
            $table->text('client_street');
            $table->text('client_city');
            $table->text('client_email')->nullable();
            $table->text('client_nip');
            $table->text('client_house_number');
            $table->text('client_postcode');
            $table->text('client_phone')->nullable();
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
        Schema::dropIfExists('clients');
    }
};
