<?php

namespace App\DTOs\Abstract;

use App\DTOs\Interfaces\BaseDTOInterface;
use Illuminate\Support\Arr;

abstract class BaseDTO implements BaseDTOInterface
{
    public function toArrayExcept(array $except = []): array
    {
        return Arr::except($this->toArray(), $except);
    }

    /**
     * Convert the DTO to an array, filtering out null and empty values.
     */
    public function toFilteredArray(): array
    {
        return array_filter($this->toArray());
    }

    /**
     * Convert the DTO to an array, filtering out null and empty values, excluding specified keys.
     */
    public function toFilteredArrayExcept(array $except = []): array
    {
        return Arr::except(array_filter($this->toArray()), $except);
    }
}
