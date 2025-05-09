<?php

namespace Spatie\LaravelOneTimePasswords;

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
}
