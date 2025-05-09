<?php

namespace Spatie\LaravelOneTimePasswords\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelOneTimePasswords\Enums\ValidateOneTimePasswordResult;

class FailedToValidateOneTimePassword
{
    public function __construct(
        public readonly Authenticatable $user,
        public readonly ValidateOneTimePasswordResult $validationResult,
    )
    {

    }
}
