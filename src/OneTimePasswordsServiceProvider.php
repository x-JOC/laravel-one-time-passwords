<?php

namespace Spatie\LaravelOneTimePasswords;

use Livewire\Livewire;
use Spatie\LaravelOneTimePasswords\Livewire\OneTimePasswordComponent;
use Spatie\LaravelOneTimePasswords\Support\Config;
use Spatie\LaravelOneTimePasswords\Support\OriginInspector\OriginEnforcer;
use Spatie\LaravelOneTimePasswords\Support\PasswordGenerators\OneTimePasswordGenerator;
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
        $this->app->bind(OriginEnforcer::class, config('one-time-passwords.origin_enforcer'));

        $this->app->bind(OneTimePasswordGenerator::class, function () {
            $generator = Config::getPasswordGenerator();

            $generator->numberOfCharacters(config('one-time-passwords.password_length'));

            return $generator;
        });

        Livewire::component('one-time-password', OneTimePasswordComponent::class);
    }
}
