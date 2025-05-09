<?php

namespace Spatie\LaravelOneTimePasswords\Actions;

use Illuminate\Http\Request;

class GatherRequestPropertiesAction
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array<string, string|int>
     */
    public function execute(Request $request): array
    {
        return [
            'ip' => $request->ip(),
            'userAgent' => $request->userAgent(),
        ];
    }
}
