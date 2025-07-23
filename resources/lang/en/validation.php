<?php

return [
    'identifier_required' => 'Email or Phone is required',
    'password_invalid' => 'Please enter a valid password',
    'currency_code' => 'The selected currency code is invalid',
    'name_required' => 'The name field is required.',
    'name_array' => 'The name must be an array.',
    'name_min' => 'At least one name is required.',
    'description_string' => 'The description must be a string.',
    'is_active_required' => 'The status field is required.',
    'is_active_boolean' => 'The status must be true or false.',
    'slug_required' => 'The slug is required.',
    'slug_unique' => 'The name is already in use.',
    'slug_string' => 'The name must be a valid string.',
    'group_required' => 'The group field is required.',
    'group_invalid' => 'The selected group is invalid.',

    'auth_failed' => 'These credentials do not match our records.',
    // Locale-aware messages
    'name_locale_required' => 'The name in :locale is required.',
    'name_locale_string' => 'The name in :locale must be a string.',

    'custom' => [
        'email' => [
            'required' => 'Email address is required.',
            'email' => 'Please enter a valid email address.',
            'unique' => 'This email address is already registered. Please use a different email or try logging in.',
        ],
        'name' => [
            'required' => 'Name is required.',
        ],
        'organization_name' => [
            'required' => 'Organization name is required.',
        ],
        'password' => [
            'required' => 'Password is required.',
            'confirmed' => 'Password confirmation does not match.',
        ],
    ],
];
