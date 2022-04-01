<?php

declare(strict_types=1);

/*
 * Clivern/Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) clivern <hello@clivern.com>
 */

namespace App\Http\Middleware;

use Closure;
use Ramsey\Uuid\Uuid;

/**
 * CorrelationId Middleware.
 */
class CorrelationId
{
    /**
     * Add Correlation ID to Incoming request & response if it is there or missing.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $newCorrelationId = Uuid::uuid4()->toString();
        $requestId        = $request->headers->has('X-Correlation-ID') ? $request->headers->get('X-Correlation-ID') : false;

        if (false === $requestId || !Uuid::isValid($requestId)) {
            $requestId = $newCorrelationId;

            $request->headers->set('X-Correlation-ID', $requestId);
        }

        $response = $next($request);
        $response->header('X-Correlation-ID', $requestId);

        return $response;
    }
}
