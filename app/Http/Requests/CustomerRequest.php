<?php

namespace App\Http\Requests;

use App\Enum\CustomerSourceEnum;
use App\Enum\CustomerStatusEnum;

class CustomerRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'country_code' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->get('status', CustomerStatusEnum::ACTIVE->value),
            'source' => $this->get('source', CustomerSourceEnum::MANUAL->value),
        ]);
    }
}
