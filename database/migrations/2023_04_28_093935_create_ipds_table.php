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
            $table->integer('patient_id');
            $table->integer('adm_officer_id')->nullable();
            $table->date('regdate');
            $table->time('regtime');
            $table->integer('spclty_id')->nullable();
            $table->integer('firstward_id')->nullable();
            $table->integer('pttype_id')->nullable();
            $table->integer('severe_type_id')->nullable();
            $table->integer('ipt_admit_type_id')->nullable();
            $table->boolean('confirm_discharge');
            $table->date('dchdate')->nullable();
            $table->time('dchtime')->nullable();
            $table->integer('dch_status_id')->nullable();
            $table->integer('dch_type_id')->nullable();
            $table->integer('dch_officer_id')->nullable();
            $table->integer('dch_severe_type_id')->nullable();
            $table->integer('dch_spclty_id')->nullable();
            $table->text('admit_for',150)->nullable();
            $table->jsonb('drainages',150)->nullable();
            $table->boolean('line_noty')->nullable();
            $table->boolean('is_screen_asses')->nullable();
            $table->string('is_vs_new',2)->nullable();
            $table->boolean('is_do_med')->nullable();
            $table->string('is_nn_new',2)->nullable();
            $table->integer('reasonadmit_type_id')->nullable();
            $table->integer('o2_type_id')->nullable();
            $table->integer('occu_type_id')->nullable();
            $table->integer('los')->nullable();
            $table->text('sdx1')->nullable();
            $table->text('sdx2')->nullable();
            $table->boolean('confirm_summary_dc')->nullable();
            $table->integer('summary_dc_officer_id')->nullable();
            $table->text('plan')->nullable();
            $table->text('operation')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
