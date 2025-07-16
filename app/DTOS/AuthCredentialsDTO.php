<?php

namespace App\DTOS;

use App\DTOS\Interfaces\BaseDTO;
use Illuminate\Http\Request;

readonly class AuthCredentialsDTO implements BaseDTO
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
           identifier:  $request->identifier,
            password: $request->password
        );
    }
}
