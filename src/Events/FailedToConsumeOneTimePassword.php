<?php

namespace Spatie\LaravelOneTimePasswords\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelOneTimePasswords\Enums\ConsumeOneTimePasswordResult;

class FailedToConsumeOneTimePassword
{
    public function __construct(
        public readonly Authenticatable $user,
        public readonly ConsumeOneTimePasswordResult $validationResult,
    ) {}
}
