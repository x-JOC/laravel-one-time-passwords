<?php

namespace Spatie\LaravelOneTimePasswords\Support\PasswordGenerators;

class NumericOneTimePasswordGenerator implements OneTimePasswordGenerator
{
    protected int $numberOfDigits = 6;

    public function numberOfDigits(int $numberOfDigits): self
    {
        $this->numberOfDigits = $numberOfDigits;

        return $this;
    }

    public function generate(): string|int
    {
        $min = 10 ** ($this->numberOfDigits - 1);
        $max = (10 ** $this->numberOfDigits) - 1;

        return rand($min, $max);
    }
}
