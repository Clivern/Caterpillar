<?php

declare(strict_types=1);

/*
 * Caterpillar - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Service;

use Illuminate\Support\Facades\Log;

/**
 * Access Service.
 */
class Access
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init Access Service");
    }

    /**
     * Check if user has permissions.
     */
    public function hasPermissions(int $userId, array $permissions): bool
    {
    }

    /**
     * Check if user has roles.
     */
    public function hasRoles(int $userId, array $roles): bool
    {
    }
}
