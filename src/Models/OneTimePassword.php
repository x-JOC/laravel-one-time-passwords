<?php

namespace Spatie\LaravelOneTimePasswords\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OneTimePassword extends Model
{
    use MassPrunable;

    public $guarded = [];

    public function casts()
    {
        return [
            'request_properties' => 'array',
            'expires_at' => 'datetime'
        ];
    }

    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function generateFor(Model $model, int $expiresInMinutes = 10): self
    {
        return $model->oneTimePasswords()->create([
            'password' => Str::random(6),
            'expires_at' => Carbon::now()->addMinutes($expiresInMinutes),
        ]);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Validate the given password against this one-time password.
     *
     * @param  string  $password
     * @return bool
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
