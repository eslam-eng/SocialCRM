<?php

use App\Models\PlanSubscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feature_plan_subscription', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PlanSubscription::class)->constrained()->cascadeOnDelete();
            $table->integer('feature_id');
            $table->string('slug');
            $table->json('name'); // as it will be translatable
            $table->enum('group', ['limit', 'feature']);
            $table->string('value');
            $table->unsignedBigInteger('usage')->default(0); // Track usage, e.g., number of accounts created
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_plan_subscriptions');
    }
};
