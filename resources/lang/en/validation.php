<?php

return [
    'identifier_required' => 'Email or Phone is required',
    'password_invalid' => 'Please enter a valid password',
    'currency_code' => 'The selected currency code is invalid',
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
