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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->string('depcode',3);
            $table->boolean('active');
            $table->text('detail',150);
            $table->integer('ward_id');
            $table->string('phone',50);
            $table->integer('hospital_department_id');
            $table->integer('stock_department_id');
            $table->integer('display_order');
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
        Schema::dropIfExists('departments');
    }
};
