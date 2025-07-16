<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseFormRequest;

class AuthFormRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
