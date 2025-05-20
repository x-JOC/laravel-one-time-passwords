<?php

namespace Spatie\LaravelOneTimePasswords\Support\PasswordGenerators;


abstract class OneTimePasswordGenerator
{
    protected int $numberOfCharacters = 6;

    public function numberOfCharacters(int $numberOfCharacters): self
    {
        $this->numberOfCharacters = $numberOfCharacters;

        return $this;
    }

    abstract public function generate(): string;
}
