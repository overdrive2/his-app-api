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
            $table->string('depcode',3)->nullable();
            $table->boolean('active');
            $table->text('detail',150)->nullable();
            $table->integer('ward_id')->nullable();
            $table->integer('spclty_id')->nullable();
            $table->string('phone',50)->nullable();
            $table->integer('hospital_department_id')->nullable();
            $table->integer('stock_department_id')->nullable();
            $table->integer('display_order')->nullable();
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
        Schema::dropIfExists('departments');
    }
};
