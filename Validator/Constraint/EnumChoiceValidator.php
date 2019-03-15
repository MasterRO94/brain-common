<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Constraint;

use Brain\Common\Enum\AbstractEnum;
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
     * @param string $value
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

        /** @var AbstractEnum $enum */
        $enum = $constraint->enum;

        // Valid choice should bail now.
        if (in_array($value, $enum::getAllValues(), true)) {
            return;
        }

        $parameters = [
            ValidatorTranslationHelper::template('value') => $value,
            ValidatorTranslationHelper::template('choices') => implode(', ', $enum::getAllTranslations()),
        ];

        $this->context
            ->buildViolation(CommonValidatorMessageEnum::MESSAGE_VALID_CHOICE)
            ->setParameters($parameters)
            ->addViolation();
    }
}
