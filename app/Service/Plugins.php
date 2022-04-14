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
 * Plugins Service.
 */
class Plugins
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        Log::info("Init Plugins Service");
    }

    /**
     * Register Plugin.
     */
    public function register(string $name): bool
    {
    }

    /**
     * Configure Plugin.
     */
    public function configure(int $id, array $configs): bool
    {
    }

    /**
     * Activate Plugin.
     */
    public function activate(int $id): bool
    {
    }

    /**
     * Deactivate Plugin.
     */
    public function deactivate(int $id): bool
    {
    }

    /**
     * Delete Plugin.
     */
    public function delete(int $id): bool
    {
    }
}
