<?php

declare(strict_types=1);

/*
 * This file is part of Clivern/Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Logging;

use Illuminate\Http\Request;

/**
 * Customize Logger.
 */
class CustomFormatter
{
    /**
     * @var null|Request
     */
    protected $request;

    /**
     * Class Constructor.
     */
    public function __construct(?Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * Append CorrelationId Processor.
     *
     * @param \Illuminate\Log\Logger $logger
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor([$this, 'addCorrelationId']);
        }
    }

    /**
     * Add CorrelationId.
     */
    public function addCorrelationId(array $record): array
    {
        $requestId = $this->request->headers->has('X-Correlation-ID')
            ? $this->request->headers->get('X-Correlation-ID') : "";

        $record['extra'] += [
            'CorrelationId' => $requestId,
        ];

        return $record;
    }
}
