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
        Schema::create('asset_request', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('request_date');
            $table->string('asset_name');
            $table->string('asset_description');
            $table->decimal('qty', 8, 2);
            $table->decimal('estimate_price', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->enum('status', ['', 'Pending', 'Approved', 'Rejected'])->nullable();
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
        Schema::dropIfExists('asset_request');
    }
};
