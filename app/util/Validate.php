<?php

declare(strict_types=1);

/*
 * Maximus - Laravel Applications Ultimate Kit.
 *
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Util;

use App\Exceptions\InvalidRequest;
use Exception;
use JsonSchema\Validator as JsonValidator;

/**
 * Validate Class.
 */
class Validate
{
    /**
     * Validate JSON against JSON Schema.
     */
    public function validate(string $data, string $schemaName): bool
    {
        $errors = $this->check($data, $schemaName);

        if (0 !== count($errors)) {
            throw new InvalidRequest($errors[0]);
        }

        return true;
    }

    /**
     * Check JSON against JSON Schema.
     */
    public function check(string $data, string $schemaName): array
    {
        try {
            $data    = empty(trim($data)) ? '{}' : $data;
            $dataObj = json_decode($data);

            if (empty($dataObj)) {
                $dataObj = json_decode('{}');
            }

            $validator = new JsonValidator();

            $validator->validate(
                $dataObj,
                (object) [
                    '$ref' => 'file://' . base_path("schemas/" . $schemaName),
                ]
            );

            $messages = [];

            if ($validator->isValid()) {
                return $messages;
            }

            foreach ($validator->getErrors() as $error) {
                $messages[] = $error['property'] . ': ' . $error['message'];
            }

            return $messages;
        } catch (Exception $e) {
            throw new InvalidRequest('Invalid request');
        }
    }
}
