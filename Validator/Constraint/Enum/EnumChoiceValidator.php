<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Constraint\Enum;

use Brain\Common\Enum\EnumInterface;
use Brain\Common\Validator\Enum\CommonValidatorMessageEnum;
use Brain\Common\Validator\Helper\ValidatorTranslationHelper;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * {@inheritdoc}
 */
final class EnumChoiceValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param EnumChoice $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        // A null value means the value is ignored.
        if ($value === null) {
            return;
        }

        // Not string should use the string validation error.
        // Note; when using the EnumType this will never be hit.
        if (is_string($value) === false) {
            $this->context
                ->buildViolation(CommonValidatorMessageEnum::MESSAGE_TYPE_STRING)
                ->addViolation();

            return;
        }

        /** @var EnumInterface $enum */
        $enum = $constraint->enum;
        $choices = $enum::all();

        if (in_array($value, $choices, true)) {
            return;
        }

        $parameters = [
            ValidatorTranslationHelper::template('value') => $value,
            ValidatorTranslationHelper::template('choices') => implode(', ', $choices),
        ];

        $this->context
            ->buildViolation(CommonValidatorMessageEnum::MESSAGE_VALID_CHOICE)
            ->setParameters($parameters)
            ->addViolation();
    }
}
