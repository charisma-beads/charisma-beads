<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\ShopException;
use Zend\View\Model\ViewModel;

class CartController extends AbstractController
{
	/**
	 * @var \Shop\Model\Cart
	 */
	protected $cart;
	
	/**
	 * @var \Shop\Service\Product
	 */
	protected $productService;
	
	public function addAction()
	{
		$request = $this->request;
		
		if (!$request->isPost()) {
			return $this->redirect()->toRoute('shop');
		}
		
		$product = $this->getProductService()->getById(
			$request->getPost('productId')
		);
	
		if (null === $product) {
			throw new ShopException(
				'Product could not be added to cart as it does not exist'
			);
		}
	
		$this->getCart()->addItem(
			$product, $request->getPost('qty')
		);
		
		$this->flashMessenger()->addInfoMessage('Added '  .$request->getPost('qty') . ' X ' . $product->getName() . ' to your cart');
	
		return $this->redirect()->toUrl($request->getPost('returnTo'));
	}
	
	public function viewAction()
	{
		return new ViewModel();
	}
	
	public function updateAction()
	{
		foreach($this->params('quantity') as $id => $value) {
			$product = $this->getProductService()->getById($id);
	
			if (null !== $product) {
				$this->getCart()->addItem($product, $value);
			}
		}
	
		/*$this->getCatalog()->setShippingCost(
			$this->params('shipping')
		);*/
	
		return $this->redirect()->toRoute('shop/cart', array(
			'action' => 'view'
		));
	}
	
	/**
	 * @return \Shop\Model\Cart
	 */
	protected function getCart()
	{
		if (!$this->cart) {
			$sl = $this->getServiceLocator();
			$this->cart = $sl->get('Shop\Model\Cart');
		}
	
		return $this->cart;
	}
	
	/**
	 * @return \Shop\Service\Product
	 */
	protected function getProductService()
	{
		if (!$this->productService) {
			$sl = $this->getServiceLocator();
			$this->productService = $sl->get('Shop\Service\Product');
		}
	
		return $this->productService;
	}
}
