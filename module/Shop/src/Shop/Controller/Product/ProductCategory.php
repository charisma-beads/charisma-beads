<?php
namespace Shop\Controller\Product;

use UthandoCommon\Controller\AbstractCrudController;

class ProductCategory extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'lft');
    protected $serviceName = 'ShopProductCategory';
    protected $route = 'admin/shop/category';
    protected $routes = [
        //'edit' => 'admin/shop/category/edit',
    ];
    
    public function indexAction()
    {
	    $this->getService()->getMapper()
	       ->setFetchEnabled(false)
	       ->setFetchDisabled(true);
	    return parent::indexAction();
    }
    
    public function listAction()
    {
        $this->getService()->getMapper()
            ->setFetchEnabled(false)
            ->setFetchDisabled(true);
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