<?php

declare(strict_types=1);

/*
 * Caterpillar - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use App\Models\Role;
use Illuminate\Support\Facades\Log;

/**
 * Role Repository.
 */
class RoleRepository
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init Role Repository");
    }
}
