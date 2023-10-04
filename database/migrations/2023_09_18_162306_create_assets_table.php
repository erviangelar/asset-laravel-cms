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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->index('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('model')->nullable();
            $table->string('description')->nullable();
            $table->string('manufactured')->nullable();
            $table->unsignedBigInteger('asset_type_id')->index();
            $table->foreign('asset_type_id')->references('id')->on('asset_types');
            $table->date('purchased_date');
            $table->decimal('price', 8, 2);
            $table->unsignedBigInteger('location_id')->index();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->string('assign_to')->nullable();
            $table->unsignedBigInteger('vendor_id')->index();
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->string('serial_number');
            $table->string('bar_code');
            $table->enum('status', ['', 'Available', 'Check Out', 'Reserve', 'Damage', 'On Repair'])->nullable();
            $table->enum('stored', ['', 'Check in', 'Check out'])->nullable();
            $table->decimal('qty', 8, 2);
            $table->integer('active_year');
            $table->string('tags');
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
        Schema::dropIfExists('assets');
    }
};
