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
        Schema::create('annual_budget', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->decimal('total_budget', 8, 2);
            $table->decimal('remaining_budget', 8, 2);
            $table->enum('status', ['', 'Active', 'Closed'])->nullable();
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
        Schema::dropIfExists('annual_budget');
    }
};
