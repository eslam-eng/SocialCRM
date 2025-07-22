<?php

namespace App\DTOs;

use App\DTOs\Abstract\BaseDTO;
use App\Enum\ActivationStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FeatureDTO extends BaseDTO
{
    public function __construct(
        public array $name,
        public string $group,
        public ?array $description = null,
        public ?bool $is_active = ActivationStatusEnum::ACTIVE->value,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            name: Arr::get($data, 'name'),
            group: Arr::get($data, 'group'),
            description: Arr::get($data, 'description'),
            is_active: Arr::get($data, 'is_active'),
        );
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            name: $request->name,
            group: $request->group,
            description: $request->description,
            is_active: $request->is_active,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'group' => $this->group,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];
    }
}
