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
        Schema::create('pttypes', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->boolean('active');
            $table->string('pttype_code',3)->nullable();
            $table->integer('pttype_price_group_id')->nullable();
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
        Schema::dropIfExists('pttypes');
    }
};
