<?php

return [
    /*
     * One time passwords should be consumed within this number of minutes
     */
    'default_expires_in_minutes' => 2,

    /*
     * When this setting is active, we'll delete all previous one time passwords for
     * a user when generating a new one
     */
    'only_one_active_one_time_password_per_user' => true,

    /*
     * This class generates a random password
     */
    'password_generator' => Spatie\LaravelOneTimePasswords\PasswordGenerators\NumericOneTimePasswordGenerator::class,

    /*
     * By default, the password generator will create a password with
     * this number of digits
     */
    'password_length' => 6,

    /*
     * The model uses to store one time passwords
     */
    'model' => Spatie\LaravelOneTimePasswords\Models\OneTimePassword::class,

    /*
     * These class are responsible for performing core tasks regarding one time passwords.
     * You can customize them by creating a class that extends the default, and
     * by specifying your custom class name here.
     */
    'actions' => [
        'gather_request_properties' => Spatie\LaravelOneTimePasswords\Actions\GatherRequestPropertiesAction::class,
        'generate_one_time_password' => Spatie\LaravelOneTimePasswords\Actions\GenerateOneTimePasswordAction::class,
        'verify_request_properties' => Spatie\LaravelOneTimePasswords\Actions\VerifyRequestPropertiesAction::class,
        'consume_one_time_password' => Spatie\LaravelOneTimePasswords\Actions\ConsumeOneTimePasswordAction::class,
    ],
];
