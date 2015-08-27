<?php

namespace Piwi\Form\Handler;

use Piwi\Form\Exception\ValidationException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract form handler
 */
abstract class AbstractFormHandler implements FormHandlerInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FormTypeInterface
     */
    private $formType;

    /**
     * @param FormFactoryInterface $formFactory
     * @param FormTypeInterface $formType
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        FormTypeInterface $formType
    ) {
        $this->formFactory = $formFactory;
        $this->formType = $formType;
    }

    /**
     * {@inheritdoc}
     */
    public function form($data = null, array $options = [])
    {
        return $this->formFactory->create($this->formType, $data, $options);
    }

    /**
     * {@inheritdoc}
     */
    final public function process(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);
        $this->postProcess($form, $request);
    }

    /**
     * @param FormInterface $form
     * @param Request $request
     */
    abstract protected function postProcess(FormInterface $form, Request $request);

    /**
     * Create validation exception
     *
     * @param FormInterface $form
     *
     * @return ValidationException
     */
    protected function createValidationException(FormInterface $form)
    {
        return new ValidationException($form);
    }

    /**
     * @return FormFactoryInterface
     */
    protected function getFormFactory()
    {
        return $this->formFactory;
    }

    /**
     * @return FormTypeInterface
     */
    protected function getFormType()
    {
        return $this->formType;
    }
}
