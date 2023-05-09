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
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->string('wardcode',3)->nullable();
            $table->boolean('active');
            $table->text('detail')->nullable();
            $table->integer('hospital_department_id')->nullable();
            $table->integer('display_order');
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
        Schema::dropIfExists('wards');
    }
};
