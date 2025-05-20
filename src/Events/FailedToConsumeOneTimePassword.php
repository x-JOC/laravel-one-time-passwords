<?php

namespace Spatie\OneTimePasswords\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\OneTimePasswords\Enums\ConsumeOneTimePasswordResult;

readonly class FailedToConsumeOneTimePassword
{
    public function __construct(
        public Authenticatable $user,
        public ConsumeOneTimePasswordResult $validationResult,
    ) {}
}
