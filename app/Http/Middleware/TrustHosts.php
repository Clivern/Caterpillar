<?php

declare(strict_types=1);

/*
 * Clivern/Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) clivern <hello@clivern.com>
 */

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array<int, null|string>
     */
    public function hosts()
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
