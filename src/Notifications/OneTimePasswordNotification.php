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

    public function __construct(public OneTimePassword $oneTimePassword) {}

    public function toMail()
    {
        return (new MailMessage)
            ->subject($this->subject())
            ->markdown('one-time-passwords::mail', [
                'oneTimePassword' => $this->oneTimePassword
            ]);
    }

    public function via()
    {
        return 'mail';
    }

    public function subject(): string
    {
        return __('one-time-passwords::notifications.one_time_password_subject', [
            'oneTimePassword' => $this->oneTimePassword->password,
        ]);
    }
}
