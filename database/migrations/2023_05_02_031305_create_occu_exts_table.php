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
        Schema::create('occu_exts', function (Blueprint $table) {
            $table->id();
            $table->integer('occu_id');
            $table->integer('occu_type_id');
            $table->decimal('value',10,2);
            $table->string('type_shift',3);
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
        Schema::dropIfExists('occu_exts');
    }
};
