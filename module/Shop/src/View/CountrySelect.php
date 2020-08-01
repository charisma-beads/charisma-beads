<?php

namespace Shop\View;

use Shop\Form\Element\CountryList;
use Common\View\AbstractViewHelper;

/**
 * Class CountrySelect
 *
 * @package Shop\View
 */
class CountrySelect extends AbstractViewHelper
{
    public function __invoke($countryId = null)
    {
        /* @var \Shop\Form\Element\CountryList $select */
        $select = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('FormElementManager')
            ->get(CountryList::class);

        $select->setName('countryId');

        $select->setCountryId($countryId);

        return $select;
    }
} 