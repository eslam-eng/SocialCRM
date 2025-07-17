<?php

namespace App\DTOs;

use App\DTOs\Abstract\BaseDTO;
use Illuminate\Http\Request;

class AuthCredentialsDTO extends BaseDTO
{
    public function __construct(
        public string $identifier,
        public string $password
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            identifier: $data['identifier'] ?? '',
            password: $data['password'] ?? ''
        );
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            identifier: $request->identifier,
            password: $request->password
        );
    }

    public function toArray(): array
    {
        return [];
    }
}
