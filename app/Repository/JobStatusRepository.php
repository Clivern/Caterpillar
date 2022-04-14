<?php

declare(strict_types=1);

/*
 * Caterpillar - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use App\Models\JobStatus;
use Illuminate\Support\Facades\Log;

/**
 * JobStatus Repository.
 */
class JobStatusRepository
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init JobStatus Repository");
    }
}
