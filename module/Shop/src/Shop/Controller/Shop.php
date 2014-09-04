<?php

namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Shop extends AbstractActionController
{
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
            $sl = $this->getServiceLocator();
            $this->productCategoryService = $sl->get('Shop\Service\Product\Category');
        }
        
        return $this->productCategoryService;
    }
}
