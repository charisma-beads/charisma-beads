<?php
namespace Shop\Controller\Product;

use Exception;
use Shop\Model\Product\Product as ProductModel;
use Shop\ShopException;
use UthandoCommon\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class Product extends AbstractCrudController
{
	protected $controllerSearchOverrides = ['sort' => 'sku'];
	protected $serviceName = 'ShopProduct';
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

	public function duplicateAction()
	{
		$id = $this->params('id', 0);

		/* @var $product ProductModel */
		$product = $this->getService()->makeDuplicate($id);

		if (!$product instanceof ProductModel) {
			throw new ShopException('No product was found with id: ' . $id);
		}

		$form = $this->getService()->getForm($product);

		$viewModel = new ViewModel([
			'form' => $form,
			'routeParams' => $this->params()->fromRoute(),
		]);

		$viewModel->setTemplate('shop/product/add');

		return $viewModel;
	}
	
	public function setEnabledAction()
	{
	   $id = (int) $this->params('id', 0);
	   
		if (!$id) {
			return $this->redirect()->toRoute($this->getRoute(), [
				'action' => 'list'
			]);
		}
		
		try {
		    /* @var $product ProductModel */
			$product = $this->getService()->getById($id);
			$result = $this->getService()->toggleEnabled($product);
		} catch (Exception $e) {
		    $this->setExceptionMessages($e);
			return $this->redirect()->toRoute($this->getRoute(), [
				'action' => 'list'
			]);
		}
		
		return $this->redirect()->toRoute($this->getRoute(), [
			'action' => 'list'
		]);
	}
}
