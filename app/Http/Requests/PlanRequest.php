<?php

namespace App\Http\Requests;

use App\Enum\SubscriptionDurationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:plans,name',
            'description' => 'string|nullable',
            'price' => 'numeric|required|min:0',
            'billing_cycle' => ['required', Rule::in(SubscriptionDurationEnum::values())],
            'is_active' => 'required|boolean',
            'trial_days' => 'required|integer|min:1',
            'currency' => 'required|string|max:10',
            'refund_days' => 'nullable|integer|min:0',
            'features' => 'array|nullable',
            'limits' => 'array|nullable',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}
