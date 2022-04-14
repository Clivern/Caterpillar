<?php

declare(strict_types=1);

/*
 * Caterpillar - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use App\Models\Job;
use Illuminate\Support\Facades\Log;

/**
 * Job Repository.
 */
class JobRepository
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init Job Repository");
    }
}
