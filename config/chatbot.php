<?php

return [
    'enabled' => env('CHATBOT_ENABLED', true),

    'provider' => env('AI_PROVIDER', 'openai'),

    'api_key' => env('AI_API_KEY'),

    'model' => env('AI_MODEL'),

    'default_locale' => env(
        'CHATBOT_DEFAULT_LOCALE',
        'fa'
    ),

    'supported_locales' => [
        'fa',
        'en',
        'ar',
    ],
];
