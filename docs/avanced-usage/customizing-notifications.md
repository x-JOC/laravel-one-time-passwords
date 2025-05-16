---
title: Customizing notifications
weight: 2
---

The package uses the included `OneTimePasswordNotification` notification to send one-time passwords to users. 

### Styling the notification

The easiest way to customize the looks is by publishing the views.

```bash
php artisan vendor:publish --tag=one-time-passwords-views
```

This will publish the views to `resources/views/vendor/one-time-passwords/mail.blade.php`. You can customize this view to change the appearance of the notification.

## Customizing the notification class

If you want to customize the notification class itself, you can do so by creating a new notification class that extends the `Spatie\Passkeys\Notifications\OneTimePasswordNotification` class.

```php
namespace App\Notifications;

use Spatie\Passkeys\Notifications\OneTimePasswordNotification;

class CustomOneTimePasswordNotification extends OneTimePasswordNotification
{
    // override methods here
}
```

Then, you can update the `config/passkeys.php` configuration file to use your custom notification class.

```php
// config/passkeys.php

return [
    // ...
    'notification' =>  => App\Notifications\CustomOneTimePasswordNotification::class
];
```
