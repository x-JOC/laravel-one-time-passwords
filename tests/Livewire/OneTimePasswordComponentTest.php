<?php

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Spatie\LaravelOneTimePasswords\Livewire\OneTimePasswordComponent;
use Spatie\LaravelOneTimePasswords\Notifications\OneTimePasswordNotification;
use Spatie\LaravelOneTimePasswords\Tests\TestSupport\Models\User;

beforeEach(function () {
    RateLimiter::clear('one-time-password-component-send-code.test@example.com');

    config()->set('auth.providers.users.model', User::class);

    config()->set('one-time-passwords.redirect_successful_authentication_to', '/home');

    $this->user = User::factory()->create(['email' => 'test@example.com']);

    Notification::fake();
});

it('shows the email form by default', function () {
    Livewire::test(OneTimePasswordComponent::class)
        ->assertViewIs('one-time-passwords::livewire.email-form');
});

it('shows the one-time password form when email is provided during mount', function () {
    Livewire::test(OneTimePasswordComponent::class, ['email' => $this->user->email])
        ->assertSet('displayingEmailForm', false)
        ->assertSet('isFixedEmail', true)
        ->assertSet('email', $this->user->email)
        ->assertViewIs('one-time-passwords::livewire.one-time-password-form');
});

it('uses custom redirect when provided', function () {
    Livewire::test(OneTimePasswordComponent::class, ['redirectTo' => '/custom-redirect'])
        ->assertSet('redirectTo', '/custom-redirect');
});

it('validates email is required', function () {
    Livewire::test(OneTimePasswordComponent::class)
        ->call('submitEmail')
        ->assertHasErrors(['email' => 'required']);
});

it('validates email format', function () {
    Livewire::test(OneTimePasswordComponent::class)
        ->set('email', 'not-an-email')
        ->call('submitEmail')
        ->assertHasErrors(['email' => 'email']);
});

it('shows error when user not found', function () {
    Livewire::test(OneTimePasswordComponent::class)
        ->set('email', 'nonexistent@example.com')
        ->call('submitEmail')
        ->assertHasErrors('email')
        ->assertSee('We could not find a user with that email address.');
});

it('sends one-time password when email is submitted', function () {
    Livewire::test(OneTimePasswordComponent::class)
        ->set('email', $this->user->email)
        ->call('submitEmail')
        ->assertSet('displayingEmailForm', false)
        ->assertViewIs('one-time-passwords::livewire.one-time-password-form');

    Notification::assertSentTo($this->user, OneTimePasswordNotification::class);
});

it('can resend code', function () {
    Livewire::test(OneTimePasswordComponent::class)
        ->set('email', $this->user->email)
        ->set('displayingEmailForm', false)
        ->call('resendCode');

    Notification::assertSentTo($this->user, OneTimePasswordNotification::class);
});

it('validates one-time password is required', function () {

    Livewire::test(OneTimePasswordComponent::class)
        ->set('email', $this->user->email)
        ->set('displayingEmailForm', false)
        ->call('submitOneTimePassword')
        ->assertHasErrors(['oneTimePassword' => 'required']);
});

it('validates one-time password with custom rule', function () {
    $component = Livewire::test(OneTimePasswordComponent::class)
        ->set('email', $this->user->email)
        ->set('displayingEmailForm', false)
        ->set('oneTimePassword', 'invalid-otp');

    $component->call('submitOneTimePassword')
        ->assertHasErrors('oneTimePassword');
});

it('authenticates user when valid one-time password is provided', function () {
    $oneTimePassword = $this->user->createOneTimePassword();

    Livewire::test(OneTimePasswordComponent::class)
        ->set('email', $this->user->email)
        ->set('displayingEmailForm', false)
        ->set('oneTimePassword', $oneTimePassword->password)
        ->call('submitOneTimePassword')
        ->assertRedirect('/home');

    $this->assertAuthenticated();
});
