<?php

use Illuminate\Support\HtmlString;
use Spatie\OneTimePasswords\Models\OneTimePassword;
use Spatie\OneTimePasswords\Notifications\OneTimePasswordNotification;
use Spatie\OneTimePasswords\Tests\TestSupport\Models\User;

beforeEach(function () {

    /** @var User $user */
    $user = User::factory()->create();

    /** @var OneTimePassword oneTimePassword */
    $this->oneTimePassword = $user->createOneTimePassword();

});

it('can render the notification', function () {
    $notification = new OneTimePasswordNotification($this->oneTimePassword);

    $renderedMail = $notification->toMail(new stdClass())->render();

    expect($renderedMail)->toBeInstanceOf(HtmlString::class);
    expect($renderedMail->toHtml())->toContain($this->oneTimePassword->password);
});
