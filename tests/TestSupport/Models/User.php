<?php

namespace Spatie\OneTimePasswords\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\OneTimePasswords\Models\Concerns\HasOneTimePasswords;

class User extends \Illuminate\Foundation\Auth\User
{
    use HasFactory;
    use HasOneTimePasswords;
    use Notifiable;
}
