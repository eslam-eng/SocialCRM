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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->ulid('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('type')->comment('refer to is this Campaign for retention , follow-up or whatever')->nullable();
            $table->foreignIdFor(\App\Models\Channel::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('content');
            $table->tinyInteger('status')->default(\App\Enum\CampaignStatusEnum::ACTIVE->value);
            $table->tinyInteger('target')->comment('define if campaign is for specific segment,specific customers of for all')->default(\App\Enum\CampaignTargetEnum::ALL_CUSTOMERS->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compains');
    }
};
