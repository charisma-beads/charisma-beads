<?php
namespace Shop\Controller;

use User\Form\Login as LoginForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Checkout extends AbstractActionController
{
    /**
     * @var \Shop\Service\Order
     */
    protected $orderService;
    
    /**
     * @var \Shop\Service\Cart
     */
    protected $cartService;
    
    /**
     * @var \Shop\Service\Customer
     */
    protected $customerService;
    
	public function indexAction()
	{
	    if (!$this->getCartService()->getCart()->count()) {
	        return $this->redirect()->toRoute('shop');
	    }
	    
		if ($this->identity()) {
			return $this->redirect()->toRoute('shop/checkout', array(
				'action' => 'confirm-address'
			));
		}
		
		return new ViewModel(array(
			'login'       => $this->getLoginForm(),
		    'register'    => $this->getRegisterForm()
		));
	}
	
	public function confirmAddressAction()
	{
		return new ViewModel();
	}
	
	public function confirmOrderAction()
	{
	    $params = $this->params()->fromPost();
	    $submit = $this->params()->fromPost('submit', null);
	    $collect = $this->params()->fromPost('collect-instore', null);
	    
	    $customer = $this->getCustomerService()->setUser($this->identity())
	       ->getCustomerDetailsFromUserId();
	    
	    /* @var $form \Zend\Form\Form */
	    $form = $this->getServiceLocator()->get('Shop\Form\OrderConfirm');
	    $form->setInputFilter($this->getServiceLocator()->get('Shop\InputFilter\OrderConfirm'));
	    $form->init();
	    
	    if ($this->request->isPost() && 'placeOrder' === $submit) {
            $form->setData($params);
             
            if ($form->isValid()) {
                $result = $this->getOrderService()->processOrderFromCart($customer, $collect);
                
                if ($result) {
                    $this->getCartService()->clear();
                    // need to email order,
                    // add params to session and redirect to payment page.
                    $this->redirect()->toRoute('shop/payment', array(
                        'option' => $params['payment-option'],
                        'cartId' => $result,
                    ));
                }
            }
	    }
	    
	    return new ViewModel(array(
			'countryId' => $customer->getDeliveryAddress()->getCountryId(),
	        'form'      => $form,
	    ));
	}
	
	public function cancelOrderAction()
	{
	    if ($this->request->isPost()) {
	        $submit = $this->params()->fromPost('submit', null);
	        
	        if ('cancelOrder' === $submit) {
	            $this->getCartService()->clear();
	            $this->flashmessenger()->addSuccessMessage('You have successfully canceled your order.');
	            return $this->redirect()->toRoute('shop');
	        }
	    }
	    
	    return $this->redirect()->toRoute('shop');
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
	
	/**
	 * @return \Shop\Service\Order
	 */
	protected function getOrderService()
	{
	    if (!$this->orderService) {
	        $sl = $this->getServiceLocator();
	        $this->orderService = $sl->get('Shop\Service\Order');
	    }
	
	    return $this->orderService;
	}
	
	/**
	 * @return \Shop\Service\Cart
	 */
	protected function getCartService()
	{
	    if (!$this->cartService) {
	        $sl = $this->getServiceLocator();
	        $this->cartService = $sl->get('Shop\Service\Cart');
	    }
	
	    return $this->cartService;
	}
	
	public function getLoginForm()
	{
	    $form = new LoginForm();
	    $form->setData(array('returnTo' => 'shop/checkout'));
	    return $form;
	}
	
	public function getRegisterForm()
	{
	    $userService = $this->getServiceLocator()->get('User\Service\User');
	    return $userService->getForm(null, array('returnTo' => 'shop/checkout'));
	}
}