---
title: Using your own model
weight: 3
---

you want to use a custom model, you can do so by following these steps.

## Step 1: Create a custom model

Create a new model that extends the `Spatie\Passkeys\Models\Passkey` model.

```php
namespace App\Models;

use Spatie\LaravelOneTimePasswords\Models\OneTimePassword as BaseOneTimePassword;

class OneTimePassword extends BaseOneTimePassword
{
    // Add any custom properties or methods here
}
```

## Step 2: Update the configuration

Next, you need to update the `config/one-time-passwords.php` configuration file to use your custom model.

```php
// config/one-time-passwords.php

return [
    // ...
    'models' => [
        // The model used to store passkeys
        'model' => App\Models\OneTimePassword::class,
    ],
];
```
