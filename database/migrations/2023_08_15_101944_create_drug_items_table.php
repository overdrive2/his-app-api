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
        Schema::create('drug_items', function (Blueprint $table) {
            $table->id();
            $table->string('icode', 20);
            $table->string('iname', 255);
            $table->char('medtype', 1);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->string('stg', 50);
            $table->decimal('dispense_dose', 10, 2);
            $table->string('usage_unit_code', 10);
            $table->boolean('hide_dose');
            $table->JSONB('medtype_list');
            $table->boolean('active');
            $table->smallInteger('ict_stock_department_id');
            $table->smallInteger('ict_drug_national_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drug_items');
    }
};
