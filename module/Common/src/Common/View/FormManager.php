<?php

namespace Common\View;

use Zend\Form\Element;
use Zend\Form\Form;


class FormManager extends AbstractViewHelper
{
    /**
     * @param $form
     * @param array $options
     * @return Form|Element
     */
    public function __invoke($form, $options = [])
    {
        $formManager = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('FormElementManager');

        $form = $formManager->get($form, $options);

        return $form;
    }
}
