<?php
namespace Shop\Controller;

use UthandoCommon\Controller\ServiceTrait;
use Zend\Filter\Word\UnderscoreToDash;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class Checkout extends AbstractActionController
{
    use ServiceTrait;

    /**
     *
     * @var \Shop\Service\Customer\Customer
     */
    protected $customerService;

    public function indexAction()
    {
        $service = $this->getService('ShopCart');

        if (!$service->getCart()->count()) {
            return $this->redirect()->toRoute('shop');
        }
        
        if ($this->identity()) {
            return $this->redirect()->toRoute('shop/checkout', [
                'action' => 'confirm-address'
            ]);
        }
        
        return new ViewModel(array(
            'login' => $this->getLoginForm(),
            'register' => $this->getRegisterForm()
        ));
    }

    public function confirmAddressAction()
    {
        $userId = $this->identity()->getUserId();
        $customer = $this->getCustomerService()->getCustomerByUserId($userId);
        
        if ($customer->getBillingAddressId() && $customer->getDeliveryAddressId()) {
            return [];
        }
        
        return $this->redirect()->toRoute('shop/checkout', [
            'action' => 'customer-details',
        ]);
    }
    
    public function customerDetailsAction()
    {
        $userId = $this->identity()->getUserId();
        $customer = $this->getCustomerService()
            ->getCustomerDetailsFromUserId($userId);
        
        $form = $this->getService('FormElementManager')
            ->get('ShopCustomerDetails');
        
        $inputFilter = $this->getService('InputFilterManager')
            ->get('InputFilter');
        
        $form->setInputFilter($inputFilter);
        
        $form->bind($customer);
        
        return [
            'countryId' => $customer->getDeliveryAddress()->getCountryId(),
            'form' => $form,
        ];
    }

    public function confirmOrderAction()
    {
        $params = $this->params()->fromPost();
        $submit = $this->params()->fromPost('submit', null);
        $collect = $this->params()->fromPost('collect_instore', null);
        
        $customer = $this->getCustomerService()
            ->setUser($this->identity())
            ->getCustomerDetailsFromUserId();
        
        /* @var $form \Zend\Form\Form */
        $form = $this->getServiceLocator()
            ->get('FormElementManager')
            ->get('ShopOrderConfirm');
        
        $form->init();

        $form->setInputFilter($this->getServiceLocator()
            ->get('InputFilterManager')
            ->get('Shop\InputFilter\Order\Confirm'));
        
        
        if ($this->request->isPost() && 'placeOrder' === $submit) {
            $form->setData($params);
            
            if ($form->isValid()) {
                $formValues = $form->getData();
                $orderId = $this->getOrderService()->processOrderFromCart($customer, $formValues);
                
                if ($orderId) {
                    $this->getService('ShopCart')->clear(false);
                    
                    // need to email order,
                    // add params to session and redirect to payment page.
                    $orderParams = [
                        'orderId' => $orderId,
                        'collect' => $collect,
                        'requirements' => $formValues['requirements']
                    ];
                    
                    $filter = new UnderscoreToDash();
                    $action = $filter->filter($formValues['payment_option']);
                    
                    /* @var $container \Zend\Session\AbstractContainer */
                    $container = new Container('order');
                    $container->setExpirationHops(1, null);
                    $container->order = $orderParams;
                    
                    $this->redirect()->toRoute('shop/payment', [
                        'action' => lcfirst($action)
                    ]);
                }
            }
        }
        
        return new ViewModel(array(
            'countryId' => $customer->getDeliveryAddress()->getCountryId(),
            'form' => $form
        ));
    }

    public function cancelOrderAction()
    {
        if ($this->request->isPost()) {
            $submit = $this->params()->fromPost('submit', null);
            
            if ('cancelOrder' === $submit) {
                $this->getService('ShopCart')->clear();
                $this->flashmessenger()->addSuccessMessage('You have successfully canceled your order.');
                return $this->redirect()->toRoute('shop');
            }
        }
        
        return $this->redirect()->toRoute('shop');
    }

    /**
     *
     * @return \Shop\Service\Customer\Customer
     */
    public function getCustomerService()
    {
        if (! $this->customerService) {
            $sl = $this->getServiceLocator();
            $this->customerService = $sl->get('Shop\Service\Customer');
        }
        
        return $this->customerService;
    }

    /**
     *
     * @return \Shop\Service\Order\Order
     */
    protected function getOrderService()
    {
        return $this->getService('ShopOrder');
    }

    public function getLoginForm()
    {
        $form = $this->getServiceLocator()
            ->get('FormElementManager')
            ->get('UthandoUserLogin');
        $form->setData(array(
            'returnTo' => 'shop/checkout'
        ));
        return $form;
    }

    public function getRegisterForm()
    {
        $userService = $this->getServiceLocator()->get('UthandoUser\Service\User');
        return $userService->getForm(null, [
            'returnTo' => 'shop/checkout'
        ]);
    }
}