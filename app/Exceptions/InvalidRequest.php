<?php

declare(strict_types=1);

/*
 * Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Class InvalidRequest.
 */
class InvalidRequest extends Exception
{
    /**
     * Class Constructor.
     *
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct(
        string $message,
        $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            'Exception \'%s\' triggered %s%s',
            static::class,
            \PHP_EOL,
            parent::__toString()
        );
    }

    /**
     * Report the exception.
     */
    public function report()
    {
        Log::debug(sprintf("InvalidRequest Exception raised: %s", $this->getMessage()));
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'errorMessage'  => $this->getMessage(),
            'correlationId' => $request->headers->get('X-Correlation-ID'),
        ], Response::HTTP_BAD_REQUEST);
    }
}
