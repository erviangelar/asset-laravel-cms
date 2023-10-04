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
        Schema::create('asset_purchase', function (Blueprint $table) {
            $table->id();
            $table->integer('asset_request_id')->unsigned()->index();
            $table->foreign('asset_request_id')->references('id')->on('asset_request');
            $table->date('purchase_date');
            $table->integer('vendor_id')->unsigned()->index();
            $table->foreign('vendor_id')->references('id')->on('ms_vendor');
            $table->string('invoice_number');
            $table->decimal('purchase_cost', 8, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['', 'Bank Transfer', 'Credit Card', 'Virtual Transfer'])->nullable();
            $table->text('notes');
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
        Schema::dropIfExists('asset_pruchase');
    }
};
