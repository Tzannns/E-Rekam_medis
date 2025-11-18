<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteHelper
{
    /**
     * Get the current prefix (petugas or admin) from the request URL
     * Falls back to route name detection if URL detection fails
     */
    public static function getPrefix(): string
    {
        // Try to detect from request URL first (most reliable)
        $uri = request()->path();
        if (Str::startsWith($uri, 'petugas/')) {
            return 'petugas';
        }

        // Fallback to route name detection
        $routeName = Route::currentRouteName();
        if (Str::startsWith($routeName, 'petugas.')) {
            return 'petugas';
        }

        // Default to admin
        return 'admin';
    }
}
