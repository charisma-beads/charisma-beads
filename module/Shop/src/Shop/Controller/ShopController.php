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

use Shop\Service\ProductCategoryService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Common\Service\ServiceTrait;

/**
 * Class Shop
 *
 * @package Shop\Controller
 */
class ShopController extends AbstractActionController
{
    use ServiceTrait;
    
    /**
     *
     * @var \Shop\Service\ProductCategoryService
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
     * @return \Shop\Service\ProductCategoryService
     */
    protected function getProductCategoryService()
    {
        if (! $this->productCategoryService) {
            $this->productCategoryService = $this->getService(ProductCategoryService::class);
        }
        
        return $this->productCategoryService;
    }
}
