<?php

/*
 * This file is part of Maximus - Laravel Applications Ultimate Kit.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Logging;

use Illuminate\Http\Request;
use Monolog\Formatter\LineFormatter;

/**
 * Customize Logger
 */
class CustomFormatter
{
    /**
     * @var null|Request
     */
    protected $request;

    /**
     * Class Constructor
     *
     * @param null|Request $request
     */
    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * Append CorrelationId Processor
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor([$this, 'addCorrelationId']);
        }
    }

    /**
     * Add CorrelationId
     *
     * @param array $record
     * @return  array
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
