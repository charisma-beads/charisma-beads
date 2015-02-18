<?php

namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use UthandoCommon\Controller\ServiceTrait;

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
