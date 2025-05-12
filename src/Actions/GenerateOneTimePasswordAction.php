<?php

namespace Spatie\LaravelOneTimePasswords\Actions;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Spatie\LaravelOneTimePasswords\Models\Concerns\HasOneTimePasswords;
use Spatie\LaravelOneTimePasswords\Models\OneTimePassword;
use Spatie\LaravelOneTimePasswords\PasswordGenerators\OneTimePasswordGenerator;

class GenerateOneTimePasswordAction
{
    public function __construct(
        protected GatherRequestPropertiesAction $gatherRequestProperties,
        protected OneTimePasswordGenerator $passwordGenerator,
    ) {}

    /**
     * @param Authenticatable&HasOneTimePasswords $user
     * @param int|null $expiresInMinutes
     * @param \Illuminate\Http\Request|null $request
     *
     * @return OneTimePassword
     */
    public function execute(
        Authenticatable
 $user,
        ?int $expiresInMinutes = null,
        ?Request $request = null
    ): OneTimePassword {
        $expiresInMinutes = $expiresInMinutes ?? config('one-time-passwords.default_expires_in_minutes');

        return $user->oneTimePasswords()->create([
            'password' => $this->passwordGenerator->generate(),
            'expires_at' => Carbon::now()->addMinutes($expiresInMinutes),
            'request_properties' => $this->gatherRequestProperties->execute($request ?? request()),
        ]);
    }
}
