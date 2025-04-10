<?php

namespace Spatie\LaravelOneTimePasswords\Commands;

use Illuminate\Console\Command;

class LaravelOneTimePasswordsCommand extends Command
{
    public $signature = 'laravel-one-time-passwords';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
