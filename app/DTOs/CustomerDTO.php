<?php

namespace App\DTOs;

use App\DTOS\Abstract\BaseDTO;
use App\Enum\ActivationStatusEnum;
use App\Enum\CustomerSourceEnum;
use App\Enum\CustomerStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CustomerDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public ?string $country_code = null,
        public ?string $phone = null,
        public ?string $email = null,
        public ?string $address = null,
        public int $source = CustomerSourceEnum::MANUAL->value,
        public int $status = CustomerStatusEnum::ACTIVE->value,
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            name: Arr::get($data, 'name'),
            country_code: Arr::get($data, 'country_code'),
            phone: Arr::get($data, 'phone'),
            email: Arr::get($data, 'email'),
            address: Arr::get($data, 'address'),
            source: Arr::get($data, 'source', CustomerSourceEnum::MANUAL->value),
            status: Arr::get($data, 'status', ActivationStatusEnum::INACTIVE->value)
        );
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            name: $request->name,
            country_code: $request->country_code,
            phone: $request->phone,
            email: $request->email,
            address: $request->address,
            source: $request->source,
            status: $request->status
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'source' => $this->source,
            'status' => $this->status,
        ];
    }
}
