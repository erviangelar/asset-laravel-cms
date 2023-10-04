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
        Schema::create('allocation_budgets', function (Blueprint $table) {
            $table->id();
            $table->index('id');
            $table->unsignedBigInteger('budget_id')->index();
            $table->foreign('budget_id')->references('id')->on('annual_budgets');
            $table->unsignedBigInteger('asset_type_id')->index();
            $table->foreign('asset_type_id')->references('id')->on('asset_types');
            $table->decimal('allocated_amount', 20, 2);
            $table->text('notes');
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
        Schema::dropIfExists('allocation_budgets');
    }
};
