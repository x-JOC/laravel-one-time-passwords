<?php

namespace Spatie\LaravelOneTimePasswords\Models\Concerns;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\LaravelOneTimePasswords\Actions\ConsumeOneTimePasswordAction;
use Spatie\LaravelOneTimePasswords\Actions\CreateOneTimePasswordAction;
use Spatie\LaravelOneTimePasswords\Enums\ConsumeOneTimePasswordResult;
use Spatie\LaravelOneTimePasswords\Exceptions\InvalidConfig;
use Spatie\LaravelOneTimePasswords\Models\OneTimePassword;
use Spatie\LaravelOneTimePasswords\Notifications\OneTimePasswordNotification;
use Spatie\LaravelOneTimePasswords\Support\Config;

/** @mixin Model&Authenticatable */
trait HasOneTimePasswords
{
    /**
     * @return MorphMany<OneTimePassword, Model>
     *
     * @throws InvalidConfig
     */
    public function oneTimePasswords(): MorphMany
    {
        $modelClass = Config::oneTimePasswordModel();

        return $this->morphMany($modelClass, 'authenticatable');
    }

    public function deleteAllOneTimePasswords(): void
    {
        $this->oneTimePasswords()->delete();
    }

    public function createOneTimePassword(?int $expiresInMinutes = null): OneTimePassword
    {
        $action = Config::getAction('create_one_time_password', CreateOneTimePasswordAction::class);

        $expiresInMinutes = $expiresInMinutes ?? config('one-time-passwords.default_expires_in_minutes');

        return $action->execute($this, $expiresInMinutes);
    }

    public function sendOneTimePassword(?int $expiresInMinutes = null): self
    {
        $oneTimePassword = $this->createOneTimePassword($expiresInMinutes);

        $notificationClass = Config::oneTimePasswordNotificationClass();
        $this->notify(new $notificationClass($oneTimePassword));

        return $this;
    }

    public function consumeOneTimePassword(string $password): ConsumeOneTimePasswordResult
    {
        $action = Config::getAction('consume_one_time_password', ConsumeOneTimePasswordAction::class);

        return $action->execute($this, $password, request());
    }
}
