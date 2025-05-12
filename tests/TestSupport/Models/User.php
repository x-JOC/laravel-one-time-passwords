<?php

namespace Spatie\LaravelOneTimePasswords\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\LaravelOneTimePasswords\Models\Concerns\HasOneTimePasswords;

class User extends \Illuminate\Foundation\Auth\User
{
    use HasFactory;
    use HasOneTimePasswords;
}
