<?php

return [
    'identifier_required' => "L'e-mail ou le numéro de téléphone est requis.",
    'password_invalid' => 'Veuillez entrer un mot de passe valide.',
    'currency_code' => 'Le code de devise spécifié est invalide.',
    'name_required' => 'Le champ nom est requis.',
    'name_array' => 'Le nom doit être un tableau.',
    'name_min' => 'Au moins un nom est requis.',
    'description_string' => 'La description doit être une chaîne de caractères.',
    'is_active_required' => 'Le champ état est requis.',
    'is_active_boolean' => "L'état doit être vrai ou faux.",
    'slug_required' => 'Le slug est requis.',
    'slug_unique' => 'Le slug / nom est déjà utilisé.',
    'slug_string' => 'Le slug / nom doit être une chaîne de caractères.',
    'group_required' => 'Le groupe est requis.',
    'group_invalid' => 'Le groupe spécifié est invalide.',
    'auth_failed' => 'Ces identifiants ne correspondent pas à nos enregistrements.',

    // Locale-aware messages
    'name_locale_required' => 'Le nom en :locale est requis.',
    'name_locale_string' => 'Le nom en :locale doit être une chaîne de caractères.',

    'custom' => [
        'email' => [
            'required' => "L'adresse e-mail est requise.",
            'email' => "Veuillez saisir une adresse e-mail valide.",
            'unique' => "Cette adresse e-mail est déjà enregistrée. Veuillez en utiliser une autre ou vous connecter.",
        ],
        'name' => [
            'required' => 'Le nom est requis.',
        ],
        'organization_name' => [
            'required' => "Le nom de l'organisation est requis.",
        ],
        'password' => [
            'required' => 'Le mot de passe est requis.',
            'confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ],
    ],
];
