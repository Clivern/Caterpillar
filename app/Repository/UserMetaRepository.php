<?php

declare(strict_types=1);

/*
 * Caterpillar - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use App\Models\UserMeta;
use Illuminate\Support\Facades\Log;

/**
 * UserMeta Repository.
 */
class UserMetaRepository
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init UserMeta Repository");
    }
}
