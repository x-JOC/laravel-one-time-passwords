<?php

namespace Spatie\LaravelOneTimePasswords\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\LaravelOneTimePasswords\LaravelOneTimePasswords
 */
class LaravelOneTimePasswords extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Spatie\LaravelOneTimePasswords\LaravelOneTimePasswords::class;
    }
}
