<?php
namespace Shop\Controller;

use UthandoCommon\Controller\ServiceTrait;
use Zend\Filter\Word\UnderscoreToDash;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\Http\PhpEnvironment\Response;
use Zend\Form\Form;

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

        if (!$service->hasItems()) {
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
        if (!$this->getService('ShopCart')->hasItems()) {
            return $this->redirect()->toRoute('shop');
        }
        
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
        if (!$this->getService('ShopCart')->hasItems()) {
            return $this->redirect()->toRoute('shop');
        }
        
        $prg = $this->prg();
        
        $userId = $this->identity()->getUserId();
        $customer = $this->getCustomerService()
            ->getCustomerDetailsFromUserId($userId);
        
        $form = $this->getService('FormElementManager')
            ->get('ShopCustomerDetails', [
                'billing_country' => 'GB',
                'delivery_country' => 'GB',
            ]);
            
        $form->bind($customer);
        
        if ($prg instanceof Response) {
            return $prg; 
        } elseif ($prg === false) {
            if ($customer->getBillingAddressId() == $customer->getDeliveryAddressId()) {
                $form->get('shipToBilling')->setValue('1');
            }
            return [
                'countryId' => $customer->getDeliveryAddress()->getCountryId(),
                'form' => $form,
            ];
        }
        
        $result = $this->getCustomerService()
            ->updateCustomerDetails($form, $prg);
        
        if ($result instanceof Form) {
            $form = $result;
            $result = 'formError';
        }
        
        if ('formError' === $result) {
            $this->flashMessenger()->addErrorMessage('There were one or more issues with your submission. Please correct them as indicated below.');
        } elseif ($result) {
            $this->flashMessenger()->addSuccessMessage('Your changes were saved.');
            return $this->redirect()->toRoute('shop/checkout', [
                'action' => 'confirm-order',
            ]);
        } else {
            $this->flashMessenger()->addErrorMessage('Your changes could not be save due to database error.');
        }
        
        return [
            'countryId' => $customer->getDeliveryAddress()->getCountryId(),
            'form' => $form,
        ];
        
    }

    public function confirmOrderAction()
    {   
        if (!$this->getService('ShopCart')->hasItems()) {
            return $this->redirect()->toRoute('shop');
        }
        
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
                    
                    $this->redirect()->toRoute('shop/payment/default', [
                        'paymentOption' => lcfirst($action)
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
            $this->customerService = $this->getService('ShopCustomer');
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
        $form = $this->getService('FormElementManager')
            ->get('UthandoUserLogin');
        $form->setData(array(
            'returnTo' => 'shop/checkout'
        ));
        return $form;
    }

    public function getRegisterForm()
    {
        $userService = $this->getService('UthandoUser');
        return $userService->getForm(null, [
            'returnTo' => 'shop/checkout'
        ]);
    }
}