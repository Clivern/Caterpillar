<?php

declare(strict_types=1);

/*
 * Clivern/Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) clivern <hello@clivern.com>
 */

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected $except = [
    ];
}
