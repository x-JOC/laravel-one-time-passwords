<?php

namespace Spatie\LaravelOneTimePasswords\Enums;

enum ValidateOneTimePasswordResult: string
{
    case Ok = 'ok';
    case NoOneTimePasswordsFound = 'no_one_time_passwords_found';
    case IncorrectOneTimePassword = 'incorrect_one_time_password';
    case RequestDidNotMatch = 'request_did_not_match';
    case OneTimePasswordExpired = 'one_time_password_expired';

    public function isOk(): bool
    {
        return $this === self::Ok;
    }

    public function validationMessage(): string
    {
        return __('one-time-passwords::validation.'.$this->value);
    }
}
