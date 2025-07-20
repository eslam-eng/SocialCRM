<?php

namespace App\Http\Requests;

use App\Enum\FeatureGroupEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeatureRequest extends FormRequest
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
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'group' => ['required', 'boolean', Rule::in(FeatureGroupEnum::values())],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}
