<?php

use Spatie\LaravelOneTimePasswords\Enums\ValidateOneTimePasswordResult;
use Spatie\LaravelOneTimePasswords\Tests\TestSupport\Models\User;

beforeEach(function() {


    /** @var $user User */
   $user = User::factory()->create();

   $this->user = $user;
});

it('can create a one time password', function () {
    $this->user->createOneTimePassword();

    expect($this->user->oneTimePasswords)->toHaveCount(1);

    $oneTimePassword = $this->user->oneTimePasswords->first();

    expect($oneTimePassword->password)->toHaveLength(config('one-time-passwords.password_length'));
    expect($oneTimePassword->request_properties)->toHaveKeys(['ip', 'userAgent']);

    $expectedExpiresAt = now()->addMinutes(config('one-time-passwords.default_expires_in_minutes'))->toDateTimeString();
    expect($oneTimePassword->expires_at->toDateTimeString())->toBe($expectedExpiresAt);
});

it('can consume a one time password', function () {
   $oneTimePassword = $this->user->createOneTimePassword();

   $result = $this->user->consumeOneTimePassword($oneTimePassword->password);

   expect($result)->toBe(ValidateOneTimePasswordResult::Ok);
});

it('will not return ok for a wrong password', function () {
    $this->user->createOneTimePassword();

    $result = $this->user->consumeOneTimePassword('wrong-password');

    expect($result)->toBe(ValidateOneTimePasswordResult::IncorrectOneTimePassword);
});

it('will not return ok for a expired password', function (int $numberOfMinutes, ValidateOneTimePasswordResult $expectedResult) {
    $oneTimePassword = $this->user->createOneTimePassword();

    $this->travel($numberOfMinutes)->minutes();

    $result = $this->user->consumeOneTimePassword($oneTimePassword->password);

    expect($result)->toBe($expectedResult);
})->with([
    [0, ValidateOneTimePasswordResult::Ok],
    [1, ValidateOneTimePasswordResult::Ok],
    [2, ValidateOneTimePasswordResult::OneTimePasswordExpired],
]);

it('will not work again if it has already been consumed', function () {
    $oneTimePassword = $this->user->createOneTimePassword();

    $result = $this->user->consumeOneTimePassword($oneTimePassword->password);
    expect($result)->toBe(ValidateOneTimePasswordResult::Ok);

    $result = $this->user->consumeOneTimePassword($oneTimePassword->password);
    expect($result)->toBe(ValidateOneTimePasswordResult::NoOneTimePasswordsFound);
});


