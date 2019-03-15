<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * {@inheritdoc}
 *
 * @Annotation
 * @Annotation\Target({"CLASS"})
 */
final class EnumChoice extends Constraint
{
    /** @var string */
    public $enum;

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return Constraint::PROPERTY_CONSTRAINT;
    }
}
