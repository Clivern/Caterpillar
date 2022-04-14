<?php

declare(strict_types=1);

/*
 * Caterpillar - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Health Check Controller.
 */
class HealthController extends Controller
{
    /**
     * Index Action.
     */
    public function index(Request $request)
    {
        return response()->json([
            'status' => 'ok',
        ]);
    }
}
