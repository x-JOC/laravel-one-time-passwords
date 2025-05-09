<?php

namespace Spatie\LaravelOneTimePasswords\Actions;

use Illuminate\Http\Request;
use Spatie\LaravelOneTimePasswords\Models\OneTimePassword;

class VerifyRequestPropertiesAction
{
    public function execute(OneTimePassword $oneTimePassword, Request $request): bool
    {
        $requestProperties = $oneTimePassword->request_properties ?? [];

        if ($requestProperties['ip'] !== $request->ip()) {
            return false;
        }

        if ($requestProperties['userAgent'] !== $request->userAgent()) {
            return false;
        }

        return true;
    }
}
