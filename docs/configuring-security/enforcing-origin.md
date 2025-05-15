---
title: Enforcing origin
weight: 2
---

By default, the package will only accept a one-time password if the request is coming from the same origin as the page that generated it. 

The origin is determined by looking at the IP address of the request and the user agent. This is implemented in the `Spatie\LaravelOneTimePasswords\Support\OriginInspector\DefaultOriginEnforcer` class.

## Customizing the origin enforcement

You can override this behavior by implementing your own `OriginEnforcer` class. This class should implement the `Spatie\LaravelOneTimePasswords\Support\OriginInspector\OriginEnforcer` interface.

This is how that interface looks like:

```php
use Illuminate\Http\Request;
use Spatie\LaravelOneTimePasswords\Models\OneTimePassword;

interface OriginEnforcer
{
    /** @return array<string, string|int> */
    public function gatherProperties(Request $request): array;

    public function verifyProperties(OneTimePassword $oneTimePassword, Request $request): bool;
}
```

The `gatherProperties` method should return an array of properties that will be used to identify the origin of the request. The `verifyProperties` method should return `true` if the properties match, and `false` otherwise.

To see an example, take a look at the `Spatie\LaravelOneTimePasswords\Support\OriginInspector\DefaultOriginEnforcer` class in the package's source code.

## Disabling the origin enforcement

If you want to disable the origin enforcement, you can do so by setting the `origin_enforcer` config option to `Spatie\LaravelOneTimePasswords\Support\OriginInspector\DoNotEnforceOrigin` in the `one-time-passwords.php` file:

```php
// config/one-time-passwords.php

return [
    // ...

    'origin_enforcer' => Spatie\LaravelOneTimePasswords\Support\OriginInspector\DoNotEnforceOrigin::class,
];
```
