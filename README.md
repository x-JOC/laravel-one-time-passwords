# One-time passwords (OTP) for Laravel apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-one-time-passwords.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-one-time-passwords)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/spatie/laravel-one-time-passwords/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spatie/laravel-one-time-passwords/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/spatie/laravel-one-time-passwords/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/spatie/laravel-one-time-passwords/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-one-time-passwords.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-one-time-passwords)

Using this package, you can securely create and consume one-time passwords. By default, a one-time password is a number
of six digits long.

The package ships with a Livewire
component to allow users to login using a one-time password.

![image](/docs/images/form-email.png)

![image](/docs/images/form-code.png)

Alternatively, you can to build the one-time password login flow you want with the easy-to-use methods the package provides.

Here's how you would send a one-time password to a user

```php
// send a mail containing a one-time password

$user->sendOneTimePassword();
```

This is what the notification mail looks like:

![image](/docs/images/notification.png)

Here's how you would try to log in a user using a one-time password.

```php
use Spatie\LaravelOneTimePasswords\Enums\ConsumeOneTimePasswordResult;

$result = $user->attemptLoginUsingOneTimePassword($oneTimePassword);

if ($result->isOk()) {
     // it is best practice to regenerate the session id after a login   
     $request->session()->regenerate();
              
     return redirect()->intended('dashboard');
}

return back()->withErrors([
    'one_time_password' => $result->validationMessage(),
])->onlyInput('one_time_password');
```

The package tries to make one-time passwords as secure as can be by:

- letting them expire in a short timeframe (2 minutes by default)
- only allowing to consume a one-time password on the same IP and user agent as it was generated

All behavior is implemented in action classes that can be modified to your liking.


## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-one-time-passwords.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-one-time-passwords)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-one-time-passwords
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-one-time-passwords-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-one-time-passwords-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-one-time-passwords-views"
```

## Usage

```php
$laravelOneTimePasswords = new Spatie\LaravelOneTimePasswords();
echo $laravelOneTimePasswords->echoPhrase('Hello, Spatie!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
