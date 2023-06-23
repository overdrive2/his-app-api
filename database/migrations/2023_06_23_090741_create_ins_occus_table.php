<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ins_occus', function (Blueprint $table) {
            $table->id();
            $table->date('nurse_shift_date');
            $table->time('nurse_shift_time');
            $table->integer('ipd_nurse_shift_id');
            $table->integer('occu_status_id');
            $table->integer('ins_occu_branch_id');
            $table->text('note')->nullable();
            $table->integer('reported_by')->nullable();
            $table->timestamp('reported_datetime')->nullable();
            $table->boolean('reported');
            $table->integer('approved_by')->nullable();
            $table->timestamp('approved_datetime')->nullable();
            $table->boolean('approved');
            $table->boolean('line_noti');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ins_occus');
    }
};
