<?php

namespace Piwi\Form\Handler;

use Mockery;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Piwi\Form\Exception\ValidationException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

final class FormHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var FormFactoryInterface|MockInterface
     */
    private $formFactory;

    /**
     * @var FormTypeInterface|MockInterface
     */
    private $formType;

    /**
     * @var FormHandlerInterface
     */
    private $handler;

    /**
     * @var MockInterface
     */
    private $postProcessExpectation;

    public function setUp()
    {
        $this->formFactory = Mockery::mock(FormFactoryInterface::class);
        $this->formType = Mockery::mock(FormTypeInterface::class);
        $this->postProcessExpectation = Mockery::mock();
        $this->handler = new FormHandler($this->formFactory, $this->formType, $this->postProcessExpectation);
    }

    public function test_form_method()
    {
        $data = null;
        $options = [];

        $this->formFactory
            ->shouldReceive('create')
            ->once()
            ->withArgs([$this->formType, $data, $options])
            ;

        $this->handler->form($data, $options);
    }

    public function test_post_process()
    {
        $form = Mockery::mock(FormInterface::class);
        $request = Mockery::mock(Request::class);

        $form
            ->shouldReceive('handleRequest')
            ->withArgs([$request])
            ->once()
            ->andReturnUndefined()
            ;

        $this->postProcessExpectation
            ->shouldReceive('postProcess')
            ->withArgs([$form, $request])
            ->once()
            ->andReturnUndefined()
            ;

        $this->handler->process($form, $request);

        $this->assertSame($this->formFactory, $this->handler->getFormFactory());
        $this->assertSame($this->formType, $this->handler->getFormType());

        Mockery::close();
    }

    /**
     * @expectedException \Piwi\Form\Exception\ValidationException
     * @expectedExceptionMessage The form 'Foo' is invalid
     */
    public function test_validation_exception_depends_on_form()
    {
        $form = Mockery::mock(FormInterface::class);
        $form
            ->shouldReceive('getName')
            ->withNoArgs()
            ->once()
            ->andReturn('Foo')
            ;

        $exception = $this->handler->getValidationException($form);
        $this->assertSame($form, $exception->getForm());

        throw $exception;
    }
}
