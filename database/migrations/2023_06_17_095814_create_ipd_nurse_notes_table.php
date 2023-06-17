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
        Schema::create('ipd_nurse_notes', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_id');
            $table->integer('diag_id');
            $table->date('diag_date');
            $table->time('diag_time');
            $table->text('eva_result');
            $table->smallInteger('ipd_nurse_shift_id')->nullable();
            $table->smallInteger('note_type_id')->nullable();
            $table->string('note_type_desc',255);
            $table->integer('bed_id');
            $table->integer('severe_id');
            $table->integer('spclty_id');
            $table->boolean('delflag');
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
        Schema::dropIfExists('ipd_nurse_notes');
    }
};
