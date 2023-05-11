<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormService
{

    public function __construct(
        private readonly FormFactoryInterface $formFactory
    )
    {
    }

    /**
     * @template T
     * @param Request $request
     * @param string $type
     * @param T $object
     * @param array $options
     * @return array{0: bool, 1: FormInterface, 2: T}
     */
    public function processForm(Request $request, string $type, mixed $object, array $options = [])
    {

        $form = $this->formFactory->create($type, $object, $options);
        return [$form->isSubmitted() && $form->isValid(), $form, $object];
    }

}