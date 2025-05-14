<?php

use Illuminate\Support\HtmlString;
use Spatie\LaravelOneTimePasswords\Models\OneTimePassword;
use Spatie\LaravelOneTimePasswords\Notifications\OneTimePasswordNotification;
use Spatie\LaravelOneTimePasswords\Tests\TestSupport\Models\User;

beforeEach(function () {

    /** @var User $user */
    $user = User::factory()->create();

    /** @var OneTimePassword oneTimePassword */
    $this->oneTimePassword = $user->createOneTimePassword();

});

it('can render the notification', function () {
    $notification = new OneTimePasswordNotification($this->oneTimePassword);

    $renderedMail = $notification->toMail()->render();

    expect($renderedMail)->toBeInstanceOf(HtmlString::class);
    expect($renderedMail->toHtml())->toContain($this->oneTimePassword->password);
});
