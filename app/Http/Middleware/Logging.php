<?php

/*
 * This file is part of Maximus - Laravel Applications Ultimate Kit.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

/**
 * Logging Middleware
 */
class Logging
{
    /**
     * Log incoming request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::info(sprintf(
            'Incoming %s Request to %s with %s',
            $request->method(),
            $request->path(),
            !empty($request->getContent()) ? $request->getContent() : ""
        ));

        return $next($request);
    }

    /**
     * Log response
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        $headers = $response->headers->all();

        if (isset($headers["content-type"][0]) && 'application/json' === $headers["content-type"][0]) {
            Log::info(sprintf(
                'Outgoing %s Response to %s with %s',
                $response->status(),
                $request->path(),
                !empty($response->getContent()) ? $response->getContent() : ""
            ));
        } else {
            Log::info(sprintf(
                'Outgoing %s Response to %s with <!html...',
                $response->status(),
                $request->path()
            ));
        }
    }
}
