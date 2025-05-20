<?php

use Spatie\OneTimePasswords\Tests\TestSupport\TestCase;

uses(TestCase::class)->in(__DIR__);

function updateConfig(string $key, mixed $value)
{
    test()->updateConfig($key, $value);
}
