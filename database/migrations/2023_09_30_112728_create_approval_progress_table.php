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
        Schema::create('approval_progress', function (Blueprint $table) {
            $table->id();
            $table->index('id');
            $table->unsignedBigInteger('asset_request_id')->index();
            $table->foreign('asset_request_id')->references('id')->on('asset_requests');
            $table->unsignedBigInteger('workflow_approval_id')->index();
            $table->foreign('workflow_approval_id')->references('id')->on('workflow_approvals');
            $table->date('approval_date')->nullable();
            $table->Integer('approver')->nullable();
            $table->unsignedBigInteger('institution_id')->nullable();
            $table->foreign('institution_id')->references('id')->on('institutions');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('approval_progress');
    }
};
