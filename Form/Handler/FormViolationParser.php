<?php

namespace Brain\Common\Form\Handler;

use Symfony\Component\Form\FormInterface;

final class FormViolationParser
{
    /**
     * Return the form errors as an array.
     *
     * @param FormInterface $form
     * @param string|null $parent
     *
     * @return array
     */
    public static function parse(FormInterface $form, string $parent = null): array
    {
        $errors = [];

        foreach ($form as $key => $child) {
            /* @var FormInterface $child */

            if (is_null($parent)) {
                $name = $key;
            } else {
                $name = implode('.', [$parent, $key]);
            }

            foreach ($child->getErrors() as $error) {
                $errors[$name][] = $error->getMessage();
            }

            if (count($child) > 0) {
                $childErrors = self::parse($child, $name);

                foreach ($childErrors as $childErrorKey => $childError) {
                    if (!isset($errors[$childErrorKey])) {
                        $errors[$childErrorKey] = $childError;
                    }
                }
            }
        }

        $parent = $parent ?: '@form';
        foreach ($form->getErrors() as $error) {
            $errors[$parent][] = $error->getMessage();
        }

        return $errors;
    }
}
