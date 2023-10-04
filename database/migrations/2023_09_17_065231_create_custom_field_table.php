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
        Schema::create('ms_custom_field', function (Blueprint $table) {
            $table->id();
            $table->integer('asset_type_id')->unsigned()->index();
            $table->foreign('asset_type_id')->references('id')->on('ms_asset_type');
            $table->json('custom_field');
            $table->timestamps();
        });
        Schema::create('asset_custom_field', function (Blueprint $table) {
            $table->id();
            $table->integer('asset_id')->unsigned()->index();
            $table->foreign('asset_id')->references('id')->on('ms_asset');
            $table->integer('custom_field_id')->unsigned()->index();
            $table->foreign('custom_field_id')->references('id')->on('ms_custom_field');
            $table->string('value')->nullable();
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
        Schema::dropIfExists('custom_field');
    }
};
