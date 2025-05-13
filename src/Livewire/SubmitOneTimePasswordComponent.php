<?php

namespace Spatie\LaravelOneTimePasswords\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\LaravelOneTimePasswords\Rules\OneTimePasswordRule;

class SubmitOneTimePasswordComponent extends Component
{
    public string $password = '';

    public string $redirectTo = '/';

    public function mount(?string $redirectTo = null): void
    {
        $this->redirectTo = $redirectTo
            ?? config('one-time-passwords.redirect_successful_authentication_to');
    }

    public function rules(): array
    {
        return [
            'one_time_password' => ['required', new OneTimePasswordRule(Auth::user())],
        ];
    }

    public function submit()
    {
        $this->validate();

        return $this->redirect($this->redirectTo);
    }

    public function render(): View
    {
        return view('one-time-passwords::livewire.submit-one-time-password');
    }
}
