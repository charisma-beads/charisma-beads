<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use User\Form\Login as LoginForm;
use Zend\View\Model\ViewModel;

class CheckoutController extends AbstractController
{
    /**
     * @var \Shop\Service\Cart
     */
    protected $cart;
    
    /**
     * @var \Shop\Service\CustomerAddress
     */
    protected $customerAddressService;
    
	public function indexAction()
	{
	    if (!$this->getCart()->count()) {
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
	    
	}
	
	/**
	 * @return \Shop\Service\CustomerAddress
	 */
	public function getCustomerAddressService()
	{
	    if (!$this->customerAddressService) {
	    	$sl = $this->getServiceLocator();
	    	$this->customerAddressService = $sl->get('Shop\Service\CustomerAddress');
	    }
	    
	    return $this->customerAddressService;
	}
	
	/**
	 * @return \Shop\Service\Cart
	 */
	protected function getCart()
	{
	    if (!$this->cart) {
	        $sl = $this->getServiceLocator();
	        $this->cart = $sl->get('Shop\Service\Cart');
	    }
	
	    return $this->cart;
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