<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Fixture\Representation;

use Brain\Common\Representation\StringMagicRepresentationTrait;

/**
 * A class without representation interfaces.
 *
 * @internal Test fixture only.
 */
final class WithoutRepresentationTestFixture
{
    use StringMagicRepresentationTrait;
}
