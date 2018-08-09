<?php

declare(strict_types=1);

namespace Brain\Common\Form\Handler;

use Symfony\Component\Form\FormInterface;

final class FormViolationParser
{
    /**
     * Return the form errors as an array.
     *
     * @return mixed[]
     */
    public static function parse(FormInterface $form, ?string $parent = null): array
    {
        $errors = [];

        foreach ($form as $key => $child) {
            /** @var FormInterface $child */

            if ($parent === null) {
                $name = $key;
            } else {
                $name = implode('.', [$parent, $key]);
            }

            foreach ($child->getErrors() as $error) {
                $errors[$name][] = $error->getMessage();
            }

            if (count($child) <= 0) {
                continue;
            }

            $childErrors = self::parse($child, $name);

            foreach ($childErrors as $childErrorKey => $childError) {
                if (isset($errors[$childErrorKey])) {
                    continue;
                }

                $errors[$childErrorKey] = $childError;
            }
        }

        $parent = $parent ?: '@form';
        foreach ($form->getErrors() as $error) {
            $errors[$parent][] = $error->getMessage();
        }

        return $errors;
    }
}
