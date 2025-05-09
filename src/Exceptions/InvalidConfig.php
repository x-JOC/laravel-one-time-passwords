<?php

namespace Spatie\LaravelOneTimePasswords\Exceptions;

use Exception;

class InvalidConfig extends Exception
{
    public static function invalidModel(string $model): self
    {
        return new self("The configured model `{$model}` is not a valid model because it does not extend or is `Spatie\LaravelOneTimePasswords\Models\OneTimePassword`.");
    }
}
