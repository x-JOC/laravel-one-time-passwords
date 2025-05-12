<?php

namespace Spatie\LaravelOneTimePasswords\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
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
    )
    {}

    /**
     * @param Authenticatable&HasOneTimePasswords $user
     * @param string $password
     * @param Request $request
     *
     * @return ValidateOneTimePasswordResult
     */
    public function execute(
        Authenticatable $user,
        string $password,
        Request $request
    ): ValidateOneTimePasswordResult {
        $oneTimePasswords = $this->getAllOneTimePasswordsForUser($user);

        if (! count($oneTimePasswords)) {
            $this->onFailedToValidate($user, ValidateOneTimePasswordResult::NoOneTimePasswordsFound);

            return ValidateOneTimePasswordResult::NoOneTimePasswordsFound;
        }

        $oneTimePassword = $oneTimePasswords->firstWhere('password', $password);

        if (! $oneTimePassword) {
            $this->onFailedToValidate($user, ValidateOneTimePasswordResult::IncorrectOneTimePassword);

            return ValidateOneTimePasswordResult::IncorrectOneTimePassword;
        }

        if ($oneTimePassword->isExpired()) {
            $this->onFailedToValidate($user, ValidateOneTimePasswordResult::OneTimePasswordExpired);

            return ValidateOneTimePasswordResult::OneTimePasswordExpired;
        }

        $originPropertiesAreValid = $this->originEnforcer->verifyProperties(
            $oneTimePassword,
            $request,
        );

        if (! $originPropertiesAreValid) {
            $this->onFailedToValidate($user, ValidateOneTimePasswordResult::DifferentOrigin);

            return ValidateOneTimePasswordResult::DifferentOrigin;
        }

        $this->onSuccessfullyValidated($user, $oneTimePassword);

        return ValidateOneTimePasswordResult::Ok;
    }

    /**
     * @param Authenticatable&HasOneTimePasswords $user
     *
     * @return Collection<OneTimePassword>
     */
    protected function getAllOneTimePasswordsForUser(Authenticatable $user): Collection
    {
        return $user->oneTimePasswords()->get();
    }

    protected function validateRequestProperties(
        OneTimePassword $oneTimePassword,
        Request $request,
    ): bool
    {
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
    ): void {
        event(new FailedToValidateOneTimePassword($user, $validationResult));
    }
}
