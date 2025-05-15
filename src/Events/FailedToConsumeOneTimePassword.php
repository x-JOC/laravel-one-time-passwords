<?php

namespace Spatie\LaravelOneTimePasswords\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelOneTimePasswords\Enums\ConsumeOneTimePasswordResult;

readonly class FailedToConsumeOneTimePassword
{
    public function __construct(
        public Authenticatable $user,
        public ConsumeOneTimePasswordResult $validationResult,
    ) {}
}
