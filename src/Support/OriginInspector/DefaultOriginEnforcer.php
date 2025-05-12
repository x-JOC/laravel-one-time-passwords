<?php

namespace Spatie\LaravelOneTimePasswords\Support\OriginInspector;

use Illuminate\Http\Request;
use Spatie\LaravelOneTimePasswords\Models\OneTimePassword;

class DefaultOriginEnforcer implements OriginEnforcer
{
    public function gatherProperties(Request $request): array
    {
        return [
            'ip' => $request->ip(),
            'userAgent' => $request->userAgent(),
        ];
    }

    public function verifyProperties(OneTimePassword $oneTimePassword, Request $request): bool
    {
        $requestProperties = $oneTimePassword->origin_properties ?? [];

        if ($requestProperties['ip'] !== $request->ip()) {
            return false;
        }

        if ($requestProperties['userAgent'] !== $request->userAgent()) {
            return false;
        }

        return true;
    }
}
