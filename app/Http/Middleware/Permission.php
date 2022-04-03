<?php

declare(strict_types=1);

/*
 * Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Permission Middleware.
 */
class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        Log::info(sprintf(
            'Authorize Incoming %s Request to %s with Permissions %s',
            $request->method(),
            $request->path(),
            implode(", ", array_values($permissions))
        ));

        return $next($request);
    }
}
