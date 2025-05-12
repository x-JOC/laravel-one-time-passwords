<?php

namespace Spatie\LaravelOneTimePasswords;

use Spatie\LaravelOneTimePasswords\PasswordGenerators\OneTimePasswordGenerator;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OneTimePasswordsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('one-time-passwords')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasMigration('one_time_passwords');
    }

    public function packageRegistered(): void
    {
        $this->app->bind(OneTimePasswordGenerator::class, config('one-time-passwords.password_generator'));
    }
}
