<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\Model\ShopException;
use Zend\View\Model\ViewModel;
use FB;

class CartController extends AbstractController
{
	public function addAction()
	{
		$request = $this->request;
		
		if (!$request->isPost()) {
			return $this->redirect()->toRoute('shop');
		}
		
		$product = $this->getModel('Shop\Model\Catalog')->getProductById(
			$request->getPost('productId')
		);
	
		if (null === $product) {
			throw new ShopException(
				'Product could not be added to cart as it does not exist'
			);
		}
	
		$this->getModel('Shop\Model\Cart')->addItem(
			$product, $request->getPost('qty')
		);
		
		$this->flashMessenger()->addInfoMessage('Added '  .$request->getPost('qty') . ' X ' . $product->name . ' to your cart');
	
		return $this->redirect()->toUrl($request->getPost('returnTo'));
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
	
		return $this->redirect()->toRoute('shop/cart', array(
			'action' => 'view'
		));
	}
}
