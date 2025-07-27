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
        Schema::create('template_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('template_id')->constrained()->cascadeOnDelete();
            $table->string('variable_name');
            $table->string('default_value')->nullable();
            $table->boolean('is_required')->default(false);
            $table->string('integration_source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_parameters');
    }
};
