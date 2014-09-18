<?php
namespace Shop\View;

use UthandoCommon\View\AbstractViewHelper;

class ProductSearch extends AbstractViewHelper
{
    public function __invoke()
    {
    	$sl = $this->getServiceLocator()->getServiceLocator();
    	$formManager = $sl->get('FormElementManager');
        $inputFilterManager = $sl->get('InputFilterManager');

        $form = $formManager->get('ShopCatalogSearch');
    	$inputFilter = $inputFilterManager->get('ShopCatalogSearch');

    	$form->setInputFilter($inputFilter);

        return $form;
    }
}
