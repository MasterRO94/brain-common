<?php

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
     * @param Request $request
     *
     * @return array
     */
    public static function getJsonFromRequest(Request $request): array
    {
        return self::json($request->getContent());
    }

    /**
     * Return the payload from a request.
     *
     * @param Response $response
     *
     * @return array
     */
    public static function getJsonFromResponse(Response $response): array
    {
        return self::json($response->getContent());
    }

    /**
     * Return the payload from a JSON string.
     *
     * @param string $json
     *
     * @return array
     */
    public static function json(string $json): array
    {
        $payload = json_decode($json ?: '{}', true);

        //  The project will never accept a payload that is not an array.
        //  So in all cases we can default to an empty array where its not.
        return is_array($payload)
            ? $payload
            : [];
    }
}
