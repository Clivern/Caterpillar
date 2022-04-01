<?php

declare(strict_types=1);

/*
 * Clivern/Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) clivern <hello@clivern.com>
 */

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
