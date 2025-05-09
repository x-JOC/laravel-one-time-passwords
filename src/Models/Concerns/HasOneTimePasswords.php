<?php

namespace Spatie\LaravelOneTimePasswords\Models\Concerns;

use App\Models\OneTimePassword;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\LaravelOneTimePasswords\Support\Config;

/** @mixin \Illuminate\Database\Eloquent\Model */
trait HasOneTimePasswords
{
    public function oneTimePasswords(): MorphMany
    {
        $modelClass = Config::oneTimePasswordModel();

        return $this->morphMany($modelClass, 'authenticatable');
    }

    /**
     * Create a new one-time password for this model.
     *
     * @param  int  $expiresInMinutes
     * @return \App\Models\OneTimePassword
     */
    public function createOneTimePassword(int $expiresInMinutes = 10): OneTimePassword
    {
        return OneTimePassword::generateFor($this, $expiresInMinutes);
    }

    /**
     * Verify a one-time password for this model.
     *
     * @param  string  $password
     * @return bool
     */
    public function verifyOneTimePassword(string $password): bool
    {
        $otp = $this->oneTimePasswords()
            ->where('password', $password)
            ->where('expires_at', '>', now())
            ->first();

        return $otp !== null;
    }

    /**
     * Consume a one-time password, verifying it and deleting it if valid.
     *
     * @param  string  $password
     * @return bool
     */
    public function consumeOneTimePassword(string $password): bool
    {
        $otp = $this->oneTimePasswords()
            ->where('password', $password)
            ->where('expires_at', '>', now())
            ->first();

        if ($otp !== null) {
            $otp->delete();
            return true;
        }

        return false;
    }


}
