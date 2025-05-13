<?php

namespace Spatie\LaravelOneTimePasswords\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\LaravelOneTimePasswords\Rules\OneTimePasswordRule;
use Spatie\LaravelOneTimePasswords\Tests\TestSupport\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelOneTimePasswords\Models\Concerns\HasOneTimePasswords;

class SubmitOneTimePasswordComponent extends Component
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

        if (! $user) {
            $this->email = null;
        }

        $user->sendOneTimePassword();
    }

    public function submitOneTimePassword()
    {
        $user = $this->findUser();

        $this->validate([
            ['required', new OneTimePasswordRule($user)]
        ]);

        $this->authenticate($user);

        return $this->redirect($this->redirectTo);
    }

    public function render(): View
    {
        return view("one-time-passwords::livewire.{$this->showingView()}}");
    }

    /**
     * @return HasOneTimePasswords&Model&Authenticatable
     */
    protected function findUser(): ?User
    {
        return User::firstWhere('email', $this->email);
    }

    public function authenticate(User $user)
    {
        auth()->login($user);
    }

    public function showingView(): bool
    {
        return $this->email
            ? 'one-time-password-form'
            : 'email-form';
    }
}
