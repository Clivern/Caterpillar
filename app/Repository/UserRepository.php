<?php

declare(strict_types=1);

/*
 * Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * User Repository.
 */
class UserRepository
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init User Repository");
    }
}
