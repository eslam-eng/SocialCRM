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
        Schema::create('template_buttons', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('template_id')->constrained()->cascadeOnDelete();
            $table->string('button_text');
            $table->enum('button_type', ['url', 'phone', 'whatsapp', 'email'])->default('url');
            $table->string('action_value'); // URL, phone, WhatsApp number, email
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
            $table->integer('sort_order');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_buttons');
    }
};
