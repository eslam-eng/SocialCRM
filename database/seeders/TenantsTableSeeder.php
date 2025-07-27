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
            // 3. Snapshot plan features and limits to pivot table
            $featuresSnapshot = [];

            foreach ($plan->features as $feature) {
                $snapshot = $feature->only($feature->getFillable()); // includes id, slug, name, group, etc.
                $snapshot['value'] = $feature->pivot?->value;
                $featuresSnapshot[] = $snapshot;
            }

            $planSnapshot = $plan->only($plan->getFillable());

            $planSnapshot['name'] = $plan->getTranslations('name');
            // Create subscription for the tenant
            $tenant->subscription()->create([
                'plan_id' => $plan->id,
                'status' => SubscriptionStatusEnum::ACTIVE->value,
                'starts_at' => now(),
                'ends_at' => now()->addDays($plan->trial_days),
                'auto_renew' => ActivationStatusEnum::INACTIVE->value,
                'plan_snapshot' => $planSnapshot,
                'features_snapshot' => $featuresSnapshot
            ]);
        }

    }
}
