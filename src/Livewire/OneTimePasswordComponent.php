<?php

namespace Spatie\LaravelOneTimePasswords\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\LaravelOneTimePasswords\Rules\OneTimePasswordRule;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelOneTimePasswords\Models\Concerns\HasOneTimePasswords;
use \Illuminate\Database\Eloquent\Model;

class OneTimePasswordComponent extends Component
{
    public ?string $email = null;
    public string $oneTimePassword = '';

    public bool $isFixedEmail = false;
    public string $redirectTo = '/';

    public function mount(?string $redirectTo = null, ?string $email = ''): void
    {
        $this->email = $email;

        if ($this->email) {
            $this->isFixedEmail = true;
        }

        $this->redirectTo = $redirectTo
            ?? config('one-time-passwords.redirect_successful_authentication_to');
    }

    public function submitEmail()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $user = $this->findUser();

        if (!$user) {
            $this->email = null;

            $this->addError('email', 'We could not find a user with that email address.');

            return;
        }

        $user->sendOneTimePassword();
    }

    public function submitOneTimePassword()
    {
        $user = $this->findUser();

        info('validating one time password...');

        $this->validate([
            'oneTimePassword' => ['required', new OneTimePasswordRule($user)]
        ]);

        info('authenticating user...');

        $this->authenticate($user);

        info('redirecting...');

        return $this->redirect($this->redirectTo);
    }

    public function render(): View
    {
        return view("one-time-passwords::livewire.{$this->showViewName()}");
    }

    /**
     * @return HasOneTimePasswords&Model&Authenticatable
     */
    protected function findUser(): ?Authenticatable
    {
        $authenticatableModel = config('auth.providers.users.model');

        /** TODO: use real authenticatable */
        return $authenticatableModel::firstWhere('email', $this->email);
    }

    public function authenticate(Authenticatable $user)
    {
        auth()->login($user);
    }

    public function showViewName(): string
    {

        return $this->email
            ? 'one-time-password-form'
            : 'email-form';
    }
}
