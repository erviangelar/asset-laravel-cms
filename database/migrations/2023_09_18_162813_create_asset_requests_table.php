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
        Schema::create('asset_requests', function (Blueprint $table) {
            $table->id();
            $table->index('id');
            $table->string('request_no')->unique();
            $table->unsignedBigInteger('asset_type_id')->index();
            $table->foreign('asset_type_id')->references('id')->on('asset_types');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('request_date');
            $table->string('asset_name');
            $table->string('asset_description');
            $table->BigInteger('qty', 10);
            $table->BigInteger('estimate_price', 20);
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Canceled'])->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('institution_id')->nullable();
            $table->foreign('institution_id')->references('id')->on('institutions');
            $table->softDeletes();
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
        Schema::dropIfExists('asset_requests');
    }
};
