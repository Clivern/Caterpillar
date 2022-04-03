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
 * Users Service.
 */
class Users
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init Users Service");
    }
}
