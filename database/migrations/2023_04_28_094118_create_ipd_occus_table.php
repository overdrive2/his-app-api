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
        Schema::create('ipd_occus', function (Blueprint $table) {
            $table->id();
            $table->date('nurse_shift_date');
            $table->integer('ward_id');
            $table->integer('getin');
            $table->integer('getnew');
            $table->integer('getmove');
            $table->integer('moveout');
            $table->integer('discharge');
            $table->integer('getout');
            $table->integer('occu_status_id');
            $table->text('note');
            $table->integer('ipd_nurse_shift_id');
            $table->integer('severe_1');
            $table->integer('severe_2');
            $table->integer('severe_3');
            $table->integer('severe_4');
            $table->integer('severe_5');
            $table->integer('severe_6');
            $table->integer('updated_by');
            $table->integer('created_by');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_occus');
    }
};
