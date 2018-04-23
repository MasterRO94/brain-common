<?php

declare(strict_types=1);

namespace Brain\Common\Form\Handler;

use Brain\Bundle\Core\Exception\FormValidationException;
use Brain\Bundle\Core\Payload\PayloadHelper;
use Brain\Common\Debug\StopwatchInterface;
use Brain\Common\Form\Handler\Builder\FormFactory;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * A better form handler.
 *
 * Make sure that when you are using this handler every field inside the form should be using inherited values
 * for the below form options. This is so a form can be constructed with the correct validation and mapping settings
 * when working around the lack of support for the latest php type hinting.
 * * error_bubbling
 * * by_reference
 * * mapped
 *
 * It is also important that all validation constraints are moved out to the form options and all annotations on the
 * target data model are removed. As mapping is disabled when validating annotations will not be discovered.
 *
 * Note that also you do not need to have below options defined in the default form options as they are automatically
 * configured for all forms by the handler. Where possible just use the bare minimum in the default options.
 * * csrf_protection
 * * error_bubbling
 */
final class FormHandler
{
    private $request;
    private $factory;
    private $stopwatch;

    /**
     * Constructor.
     *
     * @param RequestStack $stack
     * @param FormFactory $factory
     * @param StopwatchInterface $stopwatch
     */
    public function __construct(RequestStack $stack, FormFactory $factory, StopwatchInterface $stopwatch)
    {
        $this->request = $stack->getCurrentRequest();
        $this->factory = $factory;
        $this->stopwatch = $stopwatch;
    }

    /**
     * Create and handle the form for the request.
     *
     * The manage method tries to work around some of the limitation in the Symfony form component when working with
     * type hints from PHP.
     *
     * @param string $type
     * @param mixed $data
     * @param array $options
     * @param Request|null $request
     *
     * @throws FormValidationException when form fails validation.
     *
     * @return FormInterface
     */
    public function manage(string $type, $data = null, array $options = [], Request $request = null): FormInterface
    {
        $request = $request ?: $this->request;
        $payload = PayloadHelper::getJsonFromRequest($request);

        $form = $this->create($type, $data, $options);
        $this->handle($form, $payload);

        if (!$form->isValid()) {
            throw FormValidationException::create(
                $this->getFormErrors($form)
            );
        }

        return $form;
    }

    /**
     * Create and handle a form in in partial.
     *
     * @param string $type
     * @param null $data
     * @param array $options
     * @param Request|null $request
     *
     * @return FormInterface
     */
    public function partial(string $type, $data = null, array $options = [], Request $request = null): FormInterface
    {
        $options['allow_extra_fields'] = true;
        $options['validation_groups'] = ['partial'];

        return $this->manage($type, $data, $options, $request);
    }

    /**
     * Create a form for the given request and type.
     *
     * @param string $type
     * @param mixed $data
     * @param array $options #FormOption
     *
     * @return FormInterface
     */
    private function create(string $type, $data = null, array $options = []): FormInterface
    {
        $this->stopwatch->start($type, 'form');

        //  The form name represents the key in the payload to find the data.
        //  As our API is restful and clean we give it a blank name, this will tell it to accept the entire payload.
        $builder = $this->factory->createNamedBuilder('', $type, $data, $options);

        $form = $builder->getForm();
        $this->stopwatch->stop($type);

        return $form;
    }

    /**
     * Handle the form and request.
     *
     * @param FormInterface $form
     * @param array $payload
     */
    private function handle(FormInterface $form, array $payload)
    {
        $this->stopwatch->start('form.handle', 'form');

        //  Missing values are set to null if not patch.
        $missing = ($this->request->getMethod() !== Request::METHOD_PATCH);
        $form->submit($payload, $missing);

        $this->stopwatch->stop('form.handle');
    }

    /**
     * Return the form errors as an array.
     *
     * @param FormInterface $form
     * @param string|null $parent
     *
     * @return array
     */
    private function getFormErrors(FormInterface $form, string $parent = null): array
    {
        $errors = [];

        foreach ($form as $key => $child) {
            /* @var Form $child */

            if (is_null($parent)) {
                $name = $key;
            } else {
                $name = implode('.', [$parent, $key]);
            }

            foreach ($child->getErrors() as $error) {
                $errors[$name][] = $error->getMessage();
            }

            if (count($child) > 0) {
                $childErrors = $this->getFormErrors($child, $name);

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
