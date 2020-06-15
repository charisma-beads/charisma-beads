<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

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