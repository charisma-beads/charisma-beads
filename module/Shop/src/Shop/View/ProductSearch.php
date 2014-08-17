<?php
namespace Shop\View;

use UthandoCommon\View\AbstractViewHelper;

class ProductSearch extends AbstractViewHelper
{
    public function __invoke()
    {
    	$sl = $this->getServiceLocator()->getServiceLocator();
    	$formManager = $sl->get('FormElementManager');
    	$form = $formManager->get('Shop\Form\Catalog\Search');
    	$inputFilter = $sl->get('Shop\InputFilter\Catalog\Search');
    	$form->setInputFilter($inputFilter);
        return $form;
    }
}
