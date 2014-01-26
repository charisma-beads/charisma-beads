<?php
namespace Shop\Controller;

use Shop\ShopException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Cart extends AbstractActionController
{
	/**
	 * @var \Shop\Model\Cart
	 */
	protected $cart;
	
	/**
	 * @var \Shop\Service\Product
	 */
	protected $productService;
	
	/**
	 * @var \Shop\Service\Customer
	 */
	protected $customerService;
	
	public function addAction()
	{
		if (!$this->request->isPost()) {
			return $this->redirect()->toRoute('shop');
		}
		
		$product = $this->getProductService()->getFullProductById(
			$this->params()->fromPost('productId')
		);
	
		if (null === $product) {
			throw new ShopException(
				'Product could not be added to cart as it does not exist'
			);
		}
	
		$this->getCart()->addItem(
			$product, $this->params()->fromPost('qty')
		);
		
		$this->flashMessenger()->addInfoMessage('You have added '  . $this->params()->fromPost('qty') . ' X ' . $product->getName() . ' to your cart');
	
		return $this->redirect()->toUrl($this->params()->fromPost('returnTo'));
	}
	
	public function viewAction()
	{
	    if ($this->identity()) {
	        \FB::info($this->getCustomerService()->getDeliveryAddress($this->identity()->getUserId()));
	       //$countryId = $this->getCustomerService()->getDeliveryAddress($this->identity()->getUserId())->getCountryId();
	    } else {
	        $countryId = null;
	    }
	    
		return new ViewModel(array(
			'countryId' => $countryId
	    ));
	}
	
	public function removeAction()
	{
		$id = $this->params()->fromRoute('id', 0);
		$product = $this->getProductService()->getById($id);
		
		if ($product) {
			$this->getCart()->removeItem($product);
		}
		
		return $this->redirect()->toRoute('shop/cart', array(
			'action' => 'view'
		));
	}
	
	public function updateAction()
	{
		if (!$this->request->isPost()) {
			return $this->redirect()->toRoute('shop/cart', array(
				'action' => 'view'
			));
		}
		
		foreach($this->params()->fromPost('quantity') as $id => $value) {
			$product = $this->getProductService()->getFullProductById($id);
	
			if (null !== $product) {
				$this->getCart()->addItem($product, $value);
			}
		}
	
		return $this->redirect()->toRoute('shop/cart', array(
			'action' => 'view'
		));
	}
	
	public function emptyAction()
	{
		$this->getCart()->clear();
		
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
			$this->cart = $sl->get('Shop\Service\Cart');
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
	
	/**
	 * @return \Shop\Service\Customer
	 */
	public function getCustomerService()
	{
		if (!$this->customerService) {
			$sl = $this->getServiceLocator();
			$this->customerService = $sl->get('Shop\Service\Customer');
		}
		 
		return $this->customerService;
	}
}
