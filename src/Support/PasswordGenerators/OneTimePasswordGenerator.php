<?php

namespace Spatie\LaravelOneTimePasswords\Support\PasswordGenerators;

interface OneTimePasswordGenerator
{
    public function generate(): string|int;
}
