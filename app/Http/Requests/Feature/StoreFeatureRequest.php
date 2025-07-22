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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {

        $rules = [
            'name' => 'required|array|min:1',
            'description' => 'nullable|array|min:1',
            'is_active' => 'required|boolean',
            'slug' => 'required|unique:features,slug|string',
            'group' => ['required', Rule::in(FeatureGroupEnum::values())],
        ];

    // Get supported locales from the middleware or config
        $supportedLocales = config('app.supported_locales', ['en', 'ar']);

    // Add validation rules for each supported locale
        foreach ($supportedLocales as $locale) {
            $rules["name.{$locale}"] = 'required|string';
        }
        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'slug' => Str::slug(Arr::get($this->name, 'en')),
        ]);
    }

    public function messages(): array
    {
        $messages = [
            'name.required' => __('validation.name_required'),
            'name.array' => __('validation.name_array'),
            'name.min' => __('validation.name_min'),
            'is_active.required' => __('validation.is_active_required'),
            'is_active.boolean' => __('validation.is_active_boolean'),
            'slug.required' => __('validation.slug_required'),
            'slug.unique' => __('validation.slug_unique'),
            'slug.string' => __('validation.slug_string'),
            'group.required' => __('validation.group_required'),
            'group.in' => __('validation.group_invalid'),
        ];

        $supportedLocales = config('app.supported_locales', ['en', 'ar']);

        foreach ($supportedLocales as $locale) {
            $messages["name.{$locale}.required"] = __('validation.name_locale_required', ['locale' => strtoupper($locale)]);
            $messages["name.{$locale}.string"] = __('validation.name_locale_string', ['locale' => strtoupper($locale)]);
        }

        return $messages;
    }

}
