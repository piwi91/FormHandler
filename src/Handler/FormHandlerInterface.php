<?php

namespace Piwi\Form\Handler;

use Piwi\Form\Exception\ValidationException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interfacing Form Handler
 */
interface FormHandlerInterface
{
    /**
     * Get the initialized form
     *
     * @param null $data
     * @param array $options
     *
     * @return FormInterface
     */
    public function form($data = null, array $options = []);

    /**
     * Process form and return form data after processing or throws exception if invalid
     *
     * @param FormInterface $form
     * @param Request $request
     *
     * @throws ValidationException
     *
     * @return mixed
     */
    public function process(FormInterface $form, Request $request);
}