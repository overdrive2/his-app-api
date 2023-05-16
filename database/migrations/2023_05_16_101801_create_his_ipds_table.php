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
        Schema::create('his_ipds', function (Blueprint $table) {
            $table->id();
            $table->string('an',9)->nullable();
            $table->string('admdoctor',7)->nullable();
            $table->date('dchdate')->nullable();
            $table->time('dchtime')->nullable();
            $table->string('dchstts',2)->nullable();
            $table->string('dchtype',2)->nullable();
            $table->string('dch_doctor',7)->nullable();
            $table->string('hn',9)->nullable();
            $table->string('first_ward',3)->nullable();
            $table->string('ward',3)->nullable();
            $table->date('regdate')->nullable();
            $table->time('regtime')->nullable();
            $table->text('prediag')->nullable();
            $table->string('pttype',2)->nullable();
            $table->string('spclty',2)->nullable();
            $table->string('vn',12)->nullable();
            $table->integer('ipd_admit_type_id')->nullable();
            $table->string('confirm_discharge',1)->nullable();
            $table->string('pname',50)->nullable();
            $table->string('fname',100)->nullable();
            $table->string('lname',100)->nullable();
            $table->date('birthday')->nullable();
            $table->string('cid',13)->nullable();
            $table->string('sex',1)->nullable();
            $table->string('fullname')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('his_ipds');
    }
};
