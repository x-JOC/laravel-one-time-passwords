<?php

namespace Spatie\LaravelOneTimePasswords\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Spatie\LaravelOneTimePasswords\Models\OneTimePassword;

class OneTimePasswordNotification extends Notification
{
    public bool $deleteWhenMissingModels = true;

    use Queueable;

    public function __construct(protected OneTimePassword $oneTimePassword) {}

    public function toMail()
    {
        $expiresInMinutes = config('one-time-passwords.default_expires_in_minutes');

        return (new MailMessage)
            ->greeting('Hi')
            ->line('Here is your one time password:')
            ->line($this->oneTimePassword->password)
            ->line("It is valid for {$expiresInMinutes} minutes.");
    }
}
