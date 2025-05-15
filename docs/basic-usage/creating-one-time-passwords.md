---
title: Creating one-time passwords
weight: 2
---

To create and send a one-time password to your user, call the `createOneTimePassword` method.

```php
$user->sendOneTimePassword();
```

This will create a one-time password for the user in the `one_time_passwords` table. 

