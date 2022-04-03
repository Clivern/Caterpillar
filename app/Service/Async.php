<?php

declare(strict_types=1);

/*
 * Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Service;

use Illuminate\Support\Facades\Log;

/**
 * Async Service.
 */
class Async
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init Async Service");
    }
}
