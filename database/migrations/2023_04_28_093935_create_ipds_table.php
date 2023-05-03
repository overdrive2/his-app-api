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
        Schema::create('ipds', function (Blueprint $table) {
            $table->id();
            $table->string('an',9);
            $table->string('vn',12);
            $table->string('hn',9);
            $table->integer('adm_officer_id');
            $table->date('regdate');
            $table->time('regtime');
            $table->string('spclty',2);
            $table->integer('firstward_id');
            $table->string('pttype',2);
            $table->integer('severe_type_id');
            $table->integer('ipt_admit_type_id');
            $table->boolean('confirm_discharge');
            $table->date('dchdate');
            $table->time('dchtime');
            $table->string('dchstts',2);
            $table->string('dchtype',2);
            $table->integer('dch_officer_id');
            $table->integer('dch_severe_type_id');
            $table->string('dch_spclty',2);
            $table->text('admit_for',150);
            $table->jsonb('drainages',150);
            $table->boolean('line_noty');
            $table->boolean('is_screen_asses');
            $table->string('is_vs_new',2);
            $table->boolean('is_do_med');
            $table->string('is_nn_new',2);
            $table->integer('reasonadmit_type_id');
            $table->integer('o2_type_id');
            $table->integer('occu_type_id');
            $table->integer('los');
            $table->text('sdx1');
            $table->text('sdx2');
            $table->boolean('confirm_summary_dc');
            $table->integer('summary_dc_officer_id');
            $table->text('plan');
            $table->text('operation');
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
        Schema::dropIfExists('ipds');
    }
};
