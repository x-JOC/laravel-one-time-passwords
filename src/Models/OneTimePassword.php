<?php

namespace Spatie\OneTimePasswords\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\OneTimePasswords\Actions\CreateOneTimePasswordAction;
use Spatie\OneTimePasswords\Support\Config;

class OneTimePassword extends Model
{
    use MassPrunable;

    public $guarded = [];

    public function casts()
    {
        return [
            'origin_properties' => 'array',
            'expires_at' => 'datetime',
        ];
    }

    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function generateFor(Model&Authenticatable $model, int $expiresInMinutes = 10): self
    {
        $action = Config::getAction('create_one_time_password', CreateOneTimePasswordAction::class);

        $action->execute($model, $expiresInMinutes);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Validate the given password against this one-time password.
     */
    public function validate(string $password): bool
    {
        return $this->isValid() && $this->password === $password;
    }

    public function prunable(): Builder
    {
        return static::query()->wherePast('expires_at');
    }
}
