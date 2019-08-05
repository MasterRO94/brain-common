<?php

declare(strict_types=1);

namespace Brain\Common\Form\Helper;

use Brain\Common\Form\Exception\Helper\FormMissingParentException;

use Symfony\Component\Form\FormInterface;

final class FormParentHelper
{
    /**
     * Return the forms parent.
     *
     * @throws FormMissingParentException
     */
    public static function parent(FormInterface $form, int $times): FormInterface
    {
        $times--;

        $parent = $form->getParent();

        if ($parent === null) {
            throw FormMissingParentException::create();
        }

        if ($times === 0) {
            return $parent;
        }

        return self::parent($parent, $times);
    }
}
