<?php

declare(strict_types=1);

/*
 * Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Service;

/**
 * Access Service.
 */
class Access
{
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
