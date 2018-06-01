<?php

namespace Brain\Common\System;

final class EnvironmentChecker
{
    private $environment;

    public function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    public function isProduction(): bool
    {
        return $this->environment === 'production';
    }

    public function isNonProduction(): bool
    {
        return !$this->isProduction();
    }
}
