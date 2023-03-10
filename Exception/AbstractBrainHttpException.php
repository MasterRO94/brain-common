<?php

declare(strict_types=1);

namespace Brain\Common\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

use Throwable;

/**
 * @deprecated
 */
abstract class AbstractBrainHttpException extends AbstractBrainRuntimeException implements
    HttpExceptionInterface
{
    /** @var int */
    private $statusCode;

    /** @var string[] */
    private $headers;

    /**
     * @param string[] $headers
     */
    public function __construct(
        int $statusCode,
        string $message,
        ?Throwable $previous = null,
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
