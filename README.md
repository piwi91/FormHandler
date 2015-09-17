FormHandler
===========

[![Build Status](https://travis-ci.org/piwi91/FormHandler.svg?branch=master)](https://travis-ci.org/piwi91/FormHandler)

This is a Form Handler implementation which I used in combination with the Symfony Form component.

## Usage

Implement the `FormHandlerInterface` OR extend the `AbstractFormHandler` and implement the `postProcess` method.

You can use a try/catch to catch validation exceptions.

Example:

```
public function anActionInAController(Request $request)
{
    $formHandler = new MyFancyFormHandler($formFactory, $form);

    $form = $formHandler->form();

    if ($request->isMethod('POST') {
        try {
            $formHandler->process($form, $request);
        } catch (ValidationException $e) {
            // Do something with the validation... or not ;-) (and render the page including the validation errors)
        }
    }

    return $this->render('my_view.html.twig', ['form' => $form->createView()]);
}
```
