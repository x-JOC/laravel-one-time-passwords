<?php

use Spatie\LaravelOneTimePasswords\OneTimePasswordsServiceProvider;
use Spatie\LaravelOneTimePasswords\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function updateConfig(string $key, mixed $value)
{
    test()->updateConfig($key, $value);
}
