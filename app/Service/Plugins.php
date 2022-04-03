<?php

declare(strict_types=1);

/*
 * Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Service;

/**
 * Plugins Service.
 */
class Plugins
{
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
