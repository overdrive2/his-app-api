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
        Schema::create('ipd_nurse_kardexes', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_id');
            $table->integer('diag_id');
            $table->date('start_date');
            $table->date('finish_date');
            $table->text('note');
            $table->smallInteger('ipd_nurse_shift_id')->nullable();
            $table->integer('ipd_nurse_note_id');
            $table->integer('bed_id');
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
        Schema::dropIfExists('ipd_nurse_kardexes');
    }
};
