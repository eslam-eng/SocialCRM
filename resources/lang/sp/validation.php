<?php

return [
    'identifier_required' => 'Se requiere correo electrónico o número de teléfono.',
    'password_invalid' => 'Por favor, introduzca una contraseña válida.',
    'currency_code' => 'El código de moneda especificado no es válido.',
    'name_required' => 'El campo nombre es obligatorio.',
    'name_array' => 'El nombre debe ser un arreglo.',
    'name_min' => 'Se debe proporcionar al menos un nombre.',
    'description_string' => 'La descripción debe ser una cadena de texto.',
    'is_active_required' => 'El campo de estado es obligatorio.',
    'is_active_boolean' => 'El estado debe ser verdadero o falso.',
    'slug_required' => 'El identificador (slug) es obligatorio.',
    'slug_unique' => 'El identificador / nombre ya está en uso.',
    'slug_string' => 'El identificador / nombre debe ser una cadena de texto.',
    'group_required' => 'El grupo es obligatorio.',
    'group_invalid' => 'El grupo especificado no es válido.',
    'auth_failed' => 'Estas credenciales no coinciden con nuestros registros.',

    // Locale-aware messages
    'name_locale_required' => 'El nombre en :locale es obligatorio.',
    'name_locale_string' => 'El nombre en :locale debe ser una cadena de texto.',

    'custom' => [
        'email' => [
            'required' => 'El correo electrónico es obligatorio.',
            'email' => 'Por favor, introduzca un correo electrónico válido.',
            'unique' => 'Este correo electrónico ya está registrado. Utilice otro o inicie sesión.',
        ],
        'name' => [
            'required' => 'El nombre es obligatorio.',
        ],
        'organization_name' => [
            'required' => 'El nombre de la organización es obligatorio.',
        ],
        'password' => [
            'required' => 'La contraseña es obligatoria.',
            'confirmed' => 'La confirmación de la contraseña no coincide.',
        ],
    ],
];
