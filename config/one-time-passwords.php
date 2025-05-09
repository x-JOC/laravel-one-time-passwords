<?php

return [
    'model' => Spatie\LaravelOneTimePasswords\Models\OneTimePassword::class,

    'default_expires_in_minutes' => 2,

    'actions' => [
        'gather_request_properties' => Spatie\LaravelOneTimePasswords\Actions\GatherRequestPropertiesAction::class,
        'generate_one_time_password' => Spatie\LaravelOneTimePasswords\Actions\GenerateOneTimePasswordAction::class,
        'verify_request_properties' => Spatie\LaravelOneTimePasswords\Actions\VerifyRequestPropertiesAction::class,
        'validate_one_time_password' => Spatie\LaravelOneTimePasswords\Actions\ValidateOneTimePasswordAction::class,
        ]
];
