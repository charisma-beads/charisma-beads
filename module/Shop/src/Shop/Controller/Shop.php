<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use UthandoCommon\Service\ServiceTrait;

/**
 * Class Shop
 *
 * @package Shop\Controller
 */
class Shop extends AbstractActionController
{
    use ServiceTrait;
    
    /**
     *
     * @var \Shop\Service\Product\Category
     */
    protected $productCategoryService;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function shopFrontAction()
    {
        $cats = $this->getProductCategoryService()->fetchAll(true);
        
        return new ViewModel([
            'cats' => $cats
        ]);
    }

    /**
     *
     * @return \Shop\Service\Product\Category
     */
    protected function getProductCategoryService()
    {
        if (! $this->productCategoryService) {
            $this->productCategoryService = $this->getService('ShopProductCategory');
        }
        
        return $this->productCategoryService;
    }
}
