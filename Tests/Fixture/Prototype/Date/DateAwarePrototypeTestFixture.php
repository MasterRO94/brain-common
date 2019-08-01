<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Fixture\Prototype\Date;

use Brain\Common\Prototype\Column\Date\CreatedAwareInterface;
use Brain\Common\Prototype\Column\Date\CreatedAwareTrait;
use Brain\Common\Prototype\Column\Date\DeletedAwareInterface;
use Brain\Common\Prototype\Column\Date\DeletedAwareTrait;
use Brain\Common\Prototype\Column\Date\UpdatedAwareInterface;
use Brain\Common\Prototype\Column\Date\UpdatedAwareTrait;

/**
 * An object using all date prototypes.
 *
 * @internal Use for testing only.
 */
final class DateAwarePrototypeTestFixture implements
    CreatedAwareInterface,
    UpdatedAwareInterface,
    DeletedAwareInterface
{
    use CreatedAwareTrait;
    use UpdatedAwareTrait;
    use DeletedAwareTrait;
}
