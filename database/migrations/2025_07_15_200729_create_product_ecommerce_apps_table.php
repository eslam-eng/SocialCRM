<?php

use App\Models\CommerceApp;
use App\Models\Product;
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
        Schema::create('product_ecommerce_apps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(CommerceApp::class)->constrained()->cascadeOnDelete();
            $table->string('external_id')->nullable(); // ID of the product on the platform
            $table->decimal('price', 10, 2)->nullable(); // optional override
            $table->unsignedInteger('stock')->nullable();
            $table->unique(['product_id', 'commerce_app_id', 'external_id'], 'unique_platform_product');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ecommerce_apps');
    }
};
