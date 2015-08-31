<?php

namespace Piwi\Form\Handler;

use Mockery\MockInterface;
use Piwi\Form\Exception\ValidationException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class FormHandler extends AbstractFormHandler implements FormHandlerInterface
{
    /**
     * @param FormFactoryInterface $formFactory
     * @param FormTypeInterface $formType
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        FormTypeInterface $formType,
        MockInterface $expectation
    ) {
        parent::__construct($formFactory, $formType);
        $this->expectation = $expectation;
    }

    /**
     * @param FormInterface $form
     * @param Request       $request
     */
    protected function postProcess(FormInterface $form, Request $request)
    {
        $this->expectation->postProcess($form, $request);
    }

    /**
     * @return FormFactoryInterface
     */
    public function getFormFactory()
    {
        return parent::getFormFactory();
    }

    /**
     * @return FormTypeInterface
     */
    public function getFormType()
    {
        return parent::getFormType();
    }

    /**
     * @param FormInterface $form
     *
     * @return ValidationException
     */
    public function getValidationException(FormInterface $form)
    {
        return $this->createValidationException($form);
    }
}