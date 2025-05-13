<?php

namespace Spatie\LaravelOneTimePasswords\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Spatie\LaravelOneTimePasswords\Enums\ValidateOneTimePasswordResult;
use Spatie\LaravelOneTimePasswords\Events\FailedToValidateOneTimePassword;
use Spatie\LaravelOneTimePasswords\Events\OneTimePasswordSuccessfullyValidated;
use Spatie\LaravelOneTimePasswords\Models\Concerns\HasOneTimePasswords;
use Spatie\LaravelOneTimePasswords\Models\OneTimePassword;
use Spatie\LaravelOneTimePasswords\Support\OriginInspector\OriginEnforcer;

class ConsumeOneTimePasswordAction
{
    public function __construct(
        protected OriginEnforcer $originEnforcer,
    ) {}

    /**
     * @param  Authenticatable&HasOneTimePasswords&Model  $user
     */
    public function execute(
        Authenticatable&Model $user,
        string $password,
        Request $request
    ): ValidateOneTimePasswordResult {
        $oneTimePasswords = $this->getAllOneTimePasswordsForUser($user);

        if (! $this->allowedByRateLimit($user)) {
            return $this->onFailedToValidate($user, ValidateOneTimePasswordResult::RateLimitExceeded);
        }

        if (! count($oneTimePasswords)) {
            return $this->onFailedToValidate($user, ValidateOneTimePasswordResult::NoOneTimePasswordsFound);
        }

        $oneTimePassword = $oneTimePasswords->firstWhere('password', $password);

        if (! $oneTimePassword) {
            return $this->onFailedToValidate($user, ValidateOneTimePasswordResult::IncorrectOneTimePassword);
        }

        if ($oneTimePassword->isExpired()) {
            return $this->onFailedToValidate($user, ValidateOneTimePasswordResult::OneTimePasswordExpired);
        }

        $originPropertiesAreValid = $this->originEnforcer->verifyProperties(
            $oneTimePassword,
            $request,
        );

        if (! $originPropertiesAreValid) {
            return $this->onFailedToValidate($user, ValidateOneTimePasswordResult::DifferentOrigin);
        }

        $this->onSuccessfullyValidated($user, $oneTimePassword);

        return ValidateOneTimePasswordResult::Ok;
    }

    /**
     * @param  Authenticatable&HasOneTimePasswords  $user
     * @return Collection<OneTimePassword>
     */
    protected function getAllOneTimePasswordsForUser(Authenticatable $user): Collection
    {
        return $user->oneTimePasswords()->get();
    }

    protected function validateRequestProperties(
        OneTimePassword $oneTimePassword,
        Request $request,
    ): bool {
        if ($request->userAgent() !== $oneTimePassword->origin_properties['userAgent']) {
            return false;
        }

        if ($request->ip() !== $oneTimePassword->origin_properties['ip']) {
            return false;
        }

        return true;
    }

    protected function onSuccessfullyValidated(Authenticatable $user, OneTimePassword $oneTimePassword): void
    {
        event(new OneTimePasswordSuccessfullyValidated($user, $oneTimePassword));

        $oneTimePassword->delete();
    }

    protected function onFailedToValidate(
        Authenticatable $user,
        ValidateOneTimePasswordResult $validationResult
    ): ValidateOneTimePasswordResult {
        event(new FailedToValidateOneTimePassword($user, $validationResult));

        return $validationResult;
    }

    protected function allowedByRateLimit(Authenticatable&Model $user): bool
    {
        return RateLimiter::attempt(
            "consume-one-time-password-attempt:{$user->getKey()}",
            maxAttempts: 5,
            callback: function () {},
            decaySeconds: 60
        );
    }
}
