<?php

namespace Shop\View;

use Shop\Form\CatalogSearchForm;
use Shop\InputFilter\CatalogSearchInputFilter;
use Common\View\AbstractViewHelper;

/**
 * Class ProductSearch
 *
 * @package Shop\View
 */
class ProductSearch extends AbstractViewHelper
{
    public function __invoke()
    {
    	$sl = $this->getServiceLocator()->getServiceLocator();
    	$formManager = $sl->get('FormElementManager');
        $inputFilterManager = $sl->get('InputFilterManager');

        $searchBox = $formManager->get(CatalogSearchForm::class,['name' => 'search-catalog']);
    	$inputFilter = $inputFilterManager->get(CatalogSearchInputFilter::class);

    	$searchBox->setInputFilter($inputFilter);

        return $searchBox;
    }
}
