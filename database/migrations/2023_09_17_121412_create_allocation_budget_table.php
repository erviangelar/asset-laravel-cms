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
        Schema::create('allocation_budget', function (Blueprint $table) {
            $table->id();
            $table->integer('budget_id')->unsigned()->index();
            $table->foreign('budget_id')->references('id')->on('annual_budget');
            $table->integer('asset_type_id')->unsigned()->index();
            $table->foreign('asset_type_id')->references('id')->on('ms_asset_type');
            $table->decimal('allocated_amount', 8, 2);
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
        Schema::dropIfExists('allocation_budget');
    }
};
