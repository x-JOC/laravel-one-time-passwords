<x-mail::message>
    # {{ __('one-time-passwords::notifications.email.heading') }}

    {{ __('one-time-passwords::notifications.email.intro') }}

    *{{ $oneTimePassword->password }}*

    {{ __('one-time-passwords::notifications.email.warning') }}
</x-mail::message>
