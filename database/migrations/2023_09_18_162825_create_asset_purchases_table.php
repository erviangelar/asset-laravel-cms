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
        Schema::create('asset_purchases', function (Blueprint $table) {
            $table->id();
            $table->index('id');
            $table->unsignedBigInteger('asset_request_id')->index();
            $table->foreign('asset_request_id')->references('id')->on('asset_requests');
            $table->date('purchase_date');
            $table->unsignedBigInteger('vendor_id')->index();
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->string('invoice_number');
            $table->decimal('purchase_cost', 8, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['', 'Bank Transfer', 'Credit Card', 'Virtual Transfer'])->nullable();
            $table->text('notes');
            $table->string('approval_status');
            $table->unsignedBigInteger('institution_id')->nullable();
            $table->foreign('institution_id')->references('id')->on('institutions');
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
        Schema::dropIfExists('asset_purchases');
    }
};
