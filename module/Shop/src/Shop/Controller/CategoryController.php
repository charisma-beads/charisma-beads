<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractController
{
    /**
     * @var \Shop\Service\ProductCategory
     */
    protected $productCategoryService;
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function listAction()
    {
        
    }
    
    public function addAction()
    {
        
    }
    
    public function editAction()
    {
        
    }
    
    public function deleteAction()
    {
        
    }
    
    /**
     * @return \Shop\Service\ProductCategory
     */
    protected function getProductCategoryService()
    {
        if (null === $this->productCategoryService) {
            $sl = $this->getServiceLocator();
            $this->productCategoryService = $sl->get('Shop\Service\ProductCategory');
        }
        
        return $this->productCategoryService;
    }
}