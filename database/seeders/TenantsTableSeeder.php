<?php

namespace Database\Seeders;

use App\Enum\ActivationStatusEnum;
use App\Enum\SubscriptionStatusEnum;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::factory()->count(5)->create();
        // Get plans that have trial period
        $trialPlans = Plan::trial()->get();

        if ($trialPlans->isEmpty()) {
            throw new \RuntimeException('No trial plans found. Please create plans with trial_days > 0 first.');
        }

       $tenants = Tenant::all();
        foreach ($tenants as $tenant) {
            // Randomly select a trial plan
            $plan = $trialPlans->random();

            // Create subscription for the tenant
            $subscription = $tenant->subscription()->create([
                'plan_id' => $plan->id,
                'status' => SubscriptionStatusEnum::ACTIVE->value,
                'starts_at' => now(),
                'ends_at' => now()->addDays($plan->trial_days),
                'auto_renew' => ActivationStatusEnum::INACTIVE->value,
            ]);

            // 3. Snapshot plan features and limits to pivot table
            $allFeatures = $plan->features; // Assuming this returns all features (including limits)

            $snapshot = [];

            foreach ($allFeatures as $feature) {
                $pivotData = $feature->pivot?->value ?? null;

                if (!$pivotData)
                    continue;

                $snapshot[$feature->id] = [
                    'value' => $pivotData,
                    'slug'=>$feature->slug,
                    'name'=>json_encode($feature->getTranslations('name')),
                    'group'=>$feature->group
                ];
            }
            // 4. Attach to feature_plan_subscription pivot
            $subscription->features()->attach($snapshot);
        }

    }
}
