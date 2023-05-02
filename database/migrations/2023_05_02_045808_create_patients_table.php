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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('hn',9);
            $table->string('pname',30);
            $table->string('fname',10);
            $table->boolean('lname',100);
            $table->text('cid',13);
            $table->date('birthday');
            $table->integer('sex');
            $table->boolean('is_death');
            $table->string('mobile_phone_number',50);
            $table->boolean('is_admit');
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
        Schema::dropIfExists('patients');
    }
};
