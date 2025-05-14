---
title: Introduction
weight: 1
---

Using this package, you can securely create and consume one-time passwords. By default, a one-time password is a number of six digits long.

The package provides easy-to-use methods to build the one-time password login flow you want. It also provides a Livewire component to allow users to login using a one-time password.

Here's how you would send a one-time password to a user

```php
// send a mail containing a one-time password

$user->sendOneTimePassword();
```

Here's how you would try to log in a user using a one-time password.

```php
$user->attemptLoginUsingOneTimePassword($oneTimePassword)
```

The package tries to make one-time passwords as secure as can be by:
- letting them expire in a short timeframe (2 minutes by default)
- only allowing to consume a one-time password on the same IP and user agent as it was generated

All behavior is implemented in action classes that can be modified to your liking.
