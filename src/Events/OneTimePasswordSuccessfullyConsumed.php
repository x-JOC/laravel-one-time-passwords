<?php

namespace Spatie\OneTimePasswords\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\OneTimePasswords\Models\OneTimePassword;

readonly class OneTimePasswordSuccessfullyConsumed
{
    public function __construct(
        protected Authenticatable $user,
        protected OneTimePassword $oneTimePassword,
    ) {}
}
