<?php

namespace App\Http\Requests\Feature;

use App\Enum\FeatureGroupEnum;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateFeatureRequest extends BaseFormRequest
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
            'name' => 'required|array|min:1',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'slug' => ['required', 'string', Rule::unique('features', 'slug')->ignore($this->route('feature'))],
            'group' => ['required', 'boolean', Rule::in(FeatureGroupEnum::values())],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'slug' => Str::slug(Arr::get($this->name, 'en'))
        ]);
    }
}
