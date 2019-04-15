<?php

declare(strict_types=1);

namespace Brain\Common\Utility;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * A helper for request payloads.
 */
final class PayloadHelper
{
    /**
     * Return the payload from a request.
     *
     * @return mixed[]
     */
    public static function getJsonFromRequest(Request $request): array
    {
        /** @var string $body */
        $body = $request->getContent();

        return self::json($body);
    }

    /**
     * Return the payload from a request.
     *
     * @return mixed[]
     */
    public static function getJsonFromResponse(Response $response): array
    {
        return self::json($response->getContent());
    }

    /**
     * Return the payload from a JSON string.
     *
     * @return mixed[]
     */
    public static function json(string $json): array
    {
        $payload = json_decode($json ?: '{}', true);

        // The project will never accept a payload that is not an array.
        // So in all cases we can default to an empty array where its not.
        return is_array($payload)
            ? $payload
            : [];
    }
}
