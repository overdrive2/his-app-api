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
        Schema::create('ipd_order_masters', function (Blueprint $table) {
            $table->id();
            $table->string('an', 9);
            $table->string('hn', 9);
            $table->date('order_date');
            $table->time('order_time');
            $table->string('doctor_code', 30);
            $table->integer('ward_id');
            $table->integer('bed_id');
            $table->char('order_type', 1);
            $table->boolean('saved');
            $table->date('admit_date');
            $table->text('admit_for');
            $table->boolean('confirm');
            $table->integer('confirm_by');
            $table->integer('ict_oapp_id');
            $table->boolean('no_followup');
            $table->boolean('no_homemed');
            $table->smallInteger('oneday');
            $table->smallInteger('continue');
            $table->smallInteger('progress_note');
            $table->boolean('checked');
            $table->string('checked_by');
            $table->dateTime('checked_at');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_order_masters');
    }
};
