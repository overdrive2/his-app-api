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
        Schema::create('officers', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_code',10)->nullable();
            $table->integer('officer_id')->nullable();
            $table->string('login_name',100);
            $table->string('password_md5',200);
            $table->string('fullname',200);
            $table->string('pname',50);
            $table->string('fname',100);
            $table->string('lname',100);
            $table->boolean('active');
            $table->string('licenseno',100)->nullable();
            $table->string('cid',13)->nullable();
            $table->integer('position_id');
            $table->boolean('auto_lockout')->nullable();
            $table->integer('auto_lockout_minute')->nullable();
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
        Schema::dropIfExists('officers');
    }
};
