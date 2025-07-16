<?php

namespace App\DTOS\Interfaces;

use Illuminate\Http\Request;

interface BaseDTO
{
    public static function fromArray(array $data): static;
    public static function fromRequest(Request $request): static;
}
