<?php

declare(strict_types=1);

/*
 * Caterpillar - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use App\Models\Permission;
use Illuminate\Support\Facades\Log;

/**
 * Permission Repository.
 */
class PermissionRepository
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init Permission Repository");
    }
}
