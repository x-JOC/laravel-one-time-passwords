<?php

namespace Spatie\LaravelOneTimePasswords\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelOneTimePasswords\Models\OneTimePassword;

class OneTimePasswordSuccessfullyValidated
{
    public function __construct(
        protected readonly Authenticatable $user,
        protected readonly OneTimePassword $oneTimePassword,
    )
    {

    }
}
