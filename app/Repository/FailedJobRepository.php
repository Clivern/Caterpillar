<?php

declare(strict_types=1);

/*
 * Caterpillar - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use Illuminate\Support\Facades\Log;

/**
 * Failed Job Repository.
 */
class FailedJobRepository
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init FailedJob Repository");
    }
}
