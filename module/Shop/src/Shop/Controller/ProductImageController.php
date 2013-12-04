<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ProductImageController extends AbstractController
{
    /**
     * @var \Shop\Service\ProductImage
     */
    protected $productImageService;
    
    public function indexAction()
    {
        $page = $this->params()->fromRoute('page', 1);
	    
	    $params = array(
	    	'sort' => 'productImageId',
	    );
	    
	    return new ViewModel(array(
	    	'images' => $this->getProductImageService()->usePaginator(array(
	    	    'limit' => 25,
	    	    'page' => $page
            ))->searchImages($params)
	    ));
    }
    
    public function listAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
        	return $this->redirect()->toRoute('admin/shop/image');
        }
         
        $params = $this->params()->fromPost();
         
        $viewModel = new ViewModel(array(
        	'images' => $this->getProductImageService()->usePaginator(array(
	    	    'limit' => 25,
	    	    'page' => $params['page']
            ))->searchImages($params)
        ));
         
        $viewModel->setTerminal(true);
         
        return $viewModel;
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
     * @return \Shop\Service\ProductImage
     */
    public function getProductImageService()
    {
        if (!$this->productImageService) {
            $sl = $this->getServiceLocator();
            $this->productImageService = $sl->get('Shop\Service\ProductImage');
        }
        
        return $this->productImageService;
    }
}
