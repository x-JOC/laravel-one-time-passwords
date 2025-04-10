<?php

namespace Spatie\LaravelOneTimePasswords;

use Spatie\LaravelOneTimePasswords\Commands\LaravelOneTimePasswordsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelOneTimePasswordsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-one-time-passwords')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_one_time_passwords_table')
            ->hasCommand(LaravelOneTimePasswordsCommand::class);
    }
}
