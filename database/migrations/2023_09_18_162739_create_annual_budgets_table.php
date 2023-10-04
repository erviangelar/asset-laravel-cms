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
        Schema::create('annual_budgets', function (Blueprint $table) {
            $table->id();
            $table->index('id');
            $table->string('year');
            $table->decimal('total_budget', 20, 2);
            $table->decimal('remaining_budget', 20, 2)->nullable();
            $table->enum('status', ['', 'Active', 'Closed'])->nullable();
            $table->text('notes')->nullable();
            $table->date('period_start');
            $table->date('period_end');
            $table->unsignedBigInteger('institution_id')->nullable();
            $table->foreign('institution_id')->references('id')->on('institutions');
            $table->date('close_at');
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
        Schema::dropIfExists('annual_budgets');
    }
};
