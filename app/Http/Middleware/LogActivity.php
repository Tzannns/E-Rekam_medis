<?php

namespace App\Http\Middleware;

use App\Models\LogAktivitas;
use Closure;
use Illuminate\Http\Request;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate(Request $request, $response)
    {
        if (auth()->check()) {
            $route = $request->route();
            $action = $route ? $route->getActionName() : 'Unknown';
            $method = $request->method();
            $url = $request->url();

            // Determine activity type
            $activity = $this->determineActivity($request, $response, $action);

            // Extract module from route
            $module = $this->extractModule($action);

            // Determine action type
            $actionType = $this->determineActionType($method, $request);

            // Log the activity
            LogAktivitas::log(
                $activity,
                $module,
                $actionType,
                "Method: {$method}, URL: {$url}, Status: {$response->getStatusCode()}",
                $request->ip(),
                $request->userAgent()
            );
        }
    }

    /**
     * Determine activity description
     */
    private function determineActivity($request, $response, $action)
    {
        $method = $request->method();
        $routeName = $request->route() ? $request->route()->getName() : '';

        // Get resource name from route
        $resource = $this->extractResourceName($routeName);

        switch ($method) {
            case 'GET':
                if (str_contains($action, 'index')) {
                    return "Melihat daftar {$resource}";
                } elseif (str_contains($action, 'create')) {
                    return "Membuka form tambah {$resource}";
                } elseif (str_contains($action, 'show')) {
                    return "Melihat detail {$resource}";
                } elseif (str_contains($action, 'edit')) {
                    return "Membuka form edit {$resource}";
                }

                return "Mengakses halaman {$resource}";

            case 'POST':
                if (str_contains($action, 'store')) {
                    return "Menambah {$resource}";
                }

                return "Membuat {$resource}";

            case 'PUT':
            case 'PATCH':
                if (str_contains($action, 'update')) {
                    return "Mengupdate {$resource}";
                }

                return "Mengubah {$resource}";

            case 'DELETE':
                if (str_contains($action, 'destroy')) {
                    return "Menghapus {$resource}";
                }

                return "Menghapus {$resource}";

            default:
                return "Mengakses {$resource}";
        }
    }

    /**
     * Extract module name from action
     */
    private function extractModule($action)
    {
        // Extract module from controller path
        if (preg_match('/Controllers\\(\w+)\\/', $action, $matches)) {
            return strtolower($matches[1]);
        }

        // Extract from route name
        $route = request()->route();
        if ($route && $route->getName()) {
            $parts = explode('.', $route->getName());
            if (count($parts) >= 2) {
                return $parts[1];
            }
        }

        return 'system';
    }

    /**
     * Extract resource name from route name
     */
    private function extractResourceName($routeName)
    {
        if (empty($routeName)) {
            return 'halaman';
        }

        $parts = explode('.', $routeName);
        if (count($parts) >= 2) {
            $resource = $parts[1];
            // Convert to readable name
            $resource = str_replace(['-', '_'], ' ', $resource);

            return $resource;
        }

        return 'halaman';
    }

    /**
     * Determine action type
     */
    private function determineActionType($method, $request)
    {
        $routeName = $request->route() ? $request->route()->getName() : '';

        if (str_contains($routeName, 'index')) {
            return 'view';
        }
        if (str_contains($routeName, 'create')) {
            return 'create';
        }
        if (str_contains($routeName, 'store')) {
            return 'store';
        }
        if (str_contains($routeName, 'show')) {
            return 'show';
        }
        if (str_contains($routeName, 'edit')) {
            return 'edit';
        }
        if (str_contains($routeName, 'update')) {
            return 'update';
        }
        if (str_contains($routeName, 'destroy')) {
            return 'delete';
        }

        switch ($method) {
            case 'GET': return 'view';
            case 'POST': return 'create';
            case 'PUT':
            case 'PATCH': return 'update';
            case 'DELETE': return 'delete';
            default: return 'unknown';
        }
    }
}
