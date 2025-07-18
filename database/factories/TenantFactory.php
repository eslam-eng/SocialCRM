<?php

namespace Database\Factories;

use App\Enum\ActivationStatusEnum;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->company();

        return [
            'id' => Str::ulid(),
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => ActivationStatusEnum::ACTIVE->value,
            'users_count' => 0,
        ];
    }

    /**
     * Indicate that the tenant is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => ActivationStatusEnum::INACTIVE->value,
        ]);
    }
}
