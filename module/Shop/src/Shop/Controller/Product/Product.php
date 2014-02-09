<?php
namespace Shop\Controller\Product;

use Exception;
use Application\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class Product extends AbstractCrudController
{
	protected $searchDefaultParams = array('sort' => 'name');
	protected $serviceName = 'Shop\Service\Product';
	protected $route = 'admin/shop/product';
	
	public function viewAction()
	{
		return new ViewModel();
	}
	
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
		    /* @var $product \Shop\Model\Product */
			$product = $this->getService()->getById($id);
			$result = $this->getService()->toggleEnabled($product);
		} catch (Exception $e) {
		    $this->setExceptionMessages($e);
			return $this->redirect()->toRoute($this->getRoute(), array(
				'action' => 'list'
			));
		}
		
		return $this->redirect()->toRoute($this->getRoute(), array(
			'action' => 'list'
		));
	}
}
