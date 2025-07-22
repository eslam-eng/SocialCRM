<?php

namespace App\Http\Requests\Feature;

use App\Enum\FeatureGroupEnum;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreFeatureRequest extends BaseFormRequest
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
            'name' => 'required|array|min:1',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'slug' => 'required|unique:features,slug|string',
            'group' => ['required', 'boolean', Rule::in(FeatureGroupEnum::values())],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'slug' => Str::slug(Arr::get($this->name,'en'))
        ]);
    }
}
