<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\Model\ShopException;
use Zend\View\Model\ViewModel;
use FB;

class CartController extends AbstractController
{
	/**
	 * @var \Shop\Model\Cart
	 */
	protected $cart;
	
	/**
	 * @var \Shop\Model\Catalog
	 */
	protected $calalogMapper;
	
	public function addAction()
	{
		$request = $this->request;
		
		if (!$request->isPost()) {
			return $this->redirect()->toRoute('shop');
		}
		
		$product = $this->getCatalogMapper()->getProductById(
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
		
		$this->flashMessenger()->addInfoMessage('Added '  .$request->getPost('qty') . ' X ' . $product->name . ' to your cart');
	
		return $this->redirect()->toUrl($request->getPost('returnTo'));
	}
	
	public function viewAction()
	{
		return new ViewModel(array(
			'cartModel' => $this->getCart()
		));
	}
	
	public function updateAction()
	{
		foreach($this->params('quantity') as $id => $value) {
			$product = $this->getCatalogMapper()->getProductById($id);
	
			if (null !== $product) {
				$this->getCart()->addItem($product, $value);
			}
		}
	
		$this->getCatalogMapper()->setShippingCost(
			$this->params('shipping')
		);
	
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
	 * @return \Shop\Model\Catalog
	 */
	protected function getCatalogMapper()
	{
		if (!$this->catalogMapper) {
			$sl = $this->getServiceLocator();
			$this->calalogMapper = $sl->get('Shop\Model\Catalog');
		}
	
		return $this->calalogMapper;
	}
}
