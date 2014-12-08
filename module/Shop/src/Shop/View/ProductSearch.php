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

        $searchBox = $formManager->get('ShopCatalogSearch',['name' => 'search-catalog']);
    	$inputFilter = $inputFilterManager->get('ShopCatalogSearch');

    	$searchBox->setInputFilter($inputFilter);

        return $searchBox;
    }
}
