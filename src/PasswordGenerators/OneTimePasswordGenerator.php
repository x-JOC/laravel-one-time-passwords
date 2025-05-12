<?php

namespace Spatie\LaravelOneTimePasswords\PasswordGenerators;

interface OneTimePasswordGenerator
{
    public function generate(): string|int;
}
