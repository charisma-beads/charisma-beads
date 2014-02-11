<?php
namespace Shop\View;

use Application\View\AbstractViewHelper;

class ProductSearch extends AbstractViewHelper
{
    public function __invoke()
    {
    	$sl = $this->getServiceLocator()->getServiceLocator();
    	$form = $sl->get('Shop\Form\CatalogSearch');
    	$inputFilter = $sl->get('Shop\InputFilter\CatalogSearch');
    	$form->setInputFilter($inputFilter);
        return $form;
    }
}
