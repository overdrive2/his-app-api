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
        Schema::create('occu_ipd_subs', function (Blueprint $table) {
            $table->id();
            $table->integer('occu_ipd_id');
            $table->integer('ipd_admit_type_id');
            $table->integer('getin');
            $table->integer('getnew');
            $table->integer('getmove');
            $table->integer('moveout');
            $table->integer('discharge');
            $table->integer('getout');
            $table->integer('severe_1');
            $table->integer('severe_2');
            $table->integer('severe_3');
            $table->integer('severe_4');
            $table->integer('severe_5');
            $table->integer('severe_6');
            $table->integer('dc_appr');
            $table->integer('dc_refer');
            $table->integer('dc_agnt');
            $table->integer('dc_esc');
            $table->integer('dc_dead');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occu_ipd_subs');
    }
};
