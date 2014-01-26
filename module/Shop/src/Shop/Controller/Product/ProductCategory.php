<?php
namespace Shop\Controller\Product;

use Application\Controller\AbstractCrudController;

class ProductCategory extends AbstractCrudController
{
    protected $searchDefaultParams = array('sort' => 'lft');
    protected $serviceName = 'Shop\Service\ProductCategory';
    protected $route = 'admin/shop/category';
    
    public function indexAction()
    {
	    $this->getService()->getMapper()->setFetchEnabled(false);
	    return parent::indexAction();
    }
    
    public function listAction()
    {
       $this->getService()->getMapper()->setFetchEnabled(false);
       return parent::listAction();
    }
    
    public function setEnabledAction()
    {
    	$id = (int) $this->params('id', 0);
    
    	if (!$id) {
    		return $this->redirect()->toRoute($this->getRoute(), array(
    			'action' => 'list'
    		));
    	}
  		
    	try {
    		$category = $this->getService()->getById($id);
    		$result = $this->getService()->toggleEnabled($category);
    	} catch (\Exception $e) {
    		$this->setExceptionMessages($e);
    	}
    
    	return $this->redirect()->toRoute($this->getRoute(), array(
    		'action' => 'list'
    	));
    }
}