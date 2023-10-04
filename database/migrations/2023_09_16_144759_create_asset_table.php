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
        Schema::create('ms_asset', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('model')->nullable();
            $table->string('description')->nullable();
            $table->string('manufactured')->nullable();
            $table->integer('asset_type_id')->unsigned()->index();
            $table->foreign('asset_type_id')->references('id')->on('ms_asset_type');
            $table->date('purchased_date');
            $table->decimal('price', 8, 2);
            $table->integer('location_id')->unsigned()->index();
            $table->foreign('location_id')->references('id')->on('ms_location');
            $table->string('assign_to')->nullable();
            $table->integer('vendor_id')->unsigned()->index();
            $table->foreign('vendor_id')->references('id')->on('ms_vendor');
            $table->string('serial_number');
            $table->string('bar_code');
            $table->enum('status', ['', 'Available', 'Check Out', 'Reserve', 'Damage', 'On Repair'])->nullable();
            $table->enum('stored', ['', 'Check in', 'Check out'])->nullable();
            $table->decimal('qty', 8, 2);
            $table->integer('active_year');
            $table->string('tags');
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
        Schema::dropIfExists('asset');
    }
};
