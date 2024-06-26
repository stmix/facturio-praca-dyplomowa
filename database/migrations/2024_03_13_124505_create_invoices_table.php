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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('invoice_num');
            $table->boolean('is_paid');
            $table->date('sale_date');
            $table->date('payment_deadline');

            $table->text('seller_name');
            $table->text('seller_street');
            $table->text('seller_city');
            $table->text('seller_email')->nullable();
            $table->text('seller_nip');
            $table->text('seller_house_number');
            $table->text('seller_postcode');
            $table->text('seller_phone')->nullable();

            $table->text('buyer_name');
            $table->text('buyer_street');
            $table->text('buyer_city');
            $table->text('buyer_email')->nullable();
            $table->text('buyer_nip');
            $table->text('buyer_house_number');
            $table->text('buyer_postcode');
            $table->text('buyer_phone')->nullable();

            $table->double('discount_total');
            $table->double('vat_total');
            $table->double('value_netto');

            $table->text('note')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
