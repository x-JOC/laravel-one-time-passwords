<?php

namespace Spatie\LaravelOneTimePasswords\Support\PasswordGenerators;

class NumericOneTimePasswordGenerator extends OneTimePasswordGenerator
{
    public function generate(): string
    {
        $min = 10 ** ($this->numberOfCharacters - 1);
        $max = (10 ** $this->numberOfCharacters) - 1;

        return (string) random_int($min, $max);
    }
}
