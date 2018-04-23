<?php

namespace Brain\Common\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

use Throwable;

/**
 * {@inheritdoc}
 */
abstract class AbstractBrainHttpException extends AbstractBrainRuntimeException implements
    HttpExceptionInterface
{
    private $statusCode;
    private $headers;

    /**
     * Constructor.
     *
     * @param int $statusCode
     * @param string $message
     * @param Throwable|null $previous
     * @param string[]|null $headers
     */
    public function __construct(
        int $statusCode,
        string $message,
        Throwable $previous = null,
        array $headers = []
    ) {
        parent::__construct($message, $previous);

        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
