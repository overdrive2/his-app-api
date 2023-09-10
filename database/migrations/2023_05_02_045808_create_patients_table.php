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
            $table->string('pname',30)->nullable();
            $table->string('fname',100)->nullable();
            $table->string('lname',100)->nullable();
            $table->text('cid',13)->nullable();
            $table->date('birthday');
            $table->integer('sex')->nullable();
            $table->boolean('is_death')->nullable();
            $table->string('mobile_phone_number',50)->nullable();
            $table->boolean('is_admit')->nullable();
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
        Schema::dropIfExists('patients');
    }
};
