<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\Model\ShopException;
use Zend\View\Model\ViewModel;

class CartController extends AbstractController
{
	public function addAction()
	{
		$product = $this->getModel('Shop\Model\Catalog')->getProductById(
			$this->params('productId')
		);
	
		if (null === $product) {
			throw new ShopException(
				'Product could not be added to cart as it does not exist'
			);
		}
	
		$this->getModel('Shop\Model\Cart')->addItem(
			$product, $this->params('qty')
		);
	
		$return = $this->params('returnto');
	
		return $this->redirect()->toRoute($return);
	}
	
	public function viewAction()
	{
		return new ViewModel(array(
			'cartModel' => $this->get('Shop\Model\Cart')
		));
	}
	
	public function updateAction()
	{
		foreach($this->params('quantity') as $id => $value) {
			$product = $this->getModel('Shop/Model/Catalog')->getProductById($id);
	
			if (null !== $product) {
				$this->getModel('Shop/Model/Cart')->addItem($product, $value);
			}
		}
	
		$this->getModel('Shop/Model/Cart')->setShippingCost(
			$this->params('shipping')
		);
	
		return $this->redirect()->toRoute('shop/cart/view');
	}
}
