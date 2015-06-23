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

use UthandoCommon\View\AbstractViewHelper;

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

        $searchBox = $formManager->get('ShopCatalogSearch',['name' => 'search-catalog']);
    	$inputFilter = $inputFilterManager->get('ShopCatalogSearch');

    	$searchBox->setInputFilter($inputFilter);

        return $searchBox;
    }
}
