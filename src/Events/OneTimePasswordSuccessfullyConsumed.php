<?php

namespace Spatie\LaravelOneTimePasswords\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelOneTimePasswords\Models\OneTimePassword;

readonly class OneTimePasswordSuccessfullyConsumed
{
    public function __construct(
        protected Authenticatable $user,
        protected OneTimePassword $oneTimePassword,
    ) {}
}
