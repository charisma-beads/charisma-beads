<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller;

use Shop\Model\Country\Country;
use UthandoCommon\Service\ServiceTrait;
use Zend\Filter\Word\UnderscoreToDash;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\Http\PhpEnvironment\Response;
use Zend\Form\Form;

/**
 * Class Checkout
 *
 * @package Shop\Controller
 */
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

        $prg = $this->prg();
        
        $userId = $this->identity()->getUserId();
        $customer = $this->getCustomerService()->getCustomerByUserId($userId);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            if ($customer->getBillingAddressId() && $customer->getDeliveryAddressId()) {
                return [
                    'customer' => $customer,
                ];
            }

            return $this->redirect()->toRoute('shop/checkout', [
                'action' => 'customer-details',
            ]);
        }

        if (isset($prg['submit']) && $prg['submit'] == 'confirmAddress') {
            return $this->redirect()->toRoute('shop/checkout', [
                'action' => 'confirm-order',
            ]);
        } else {
            return $this->redirect()->toRoute('shop/checkout', [
                'action' => 'customer-details',
            ]);
        }
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
        /* @var \Shop\Service\Country\Country $countryService */
        $countryService = $this->getService('ShopCountry');

        if (is_array($prg)) {
            $billingCountry = $countryService->getById($prg['customer']['billingAddress']['countryId']);
            $deliveryCountry = $countryService->getById($prg['customer']['deliveryAddress']['countryId']);
        } else {
            $billingCountry = $customer->getBillingAddress()->getCountry();
            $deliveryCountry = $customer->getDeliveryAddress()->getCountry();
        }
        
        $form = $this->getService('FormElementManager')
            ->get('ShopCustomerDetails', [
                'billing_country' => $billingCountry,
                'delivery_country' => $deliveryCountry,
            ]);

        $form->bind($customer);
        
        if ($prg instanceof Response) {
            return $prg; 
        } elseif ($prg === false) {
            if ($customer->getBillingAddressId() == $customer->getDeliveryAddressId()) {
                $form->get('shipToBilling')->setValue('1');
            }
            return [
                'countryId' => ($billingCountry instanceof Country) ? $billingCountry->getCountryId() : $billingCountry,
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
            'countryId' => ($billingCountry instanceof Country) ? $billingCountry->getCountryId() : $billingCountry,
            'form' => $form,
        ];
        
    }

    public function confirmOrderAction()
    {   
        if (!$this->getService('ShopCart')->hasItems()) {
            return $this->redirect()->toRoute('shop');
        }

        $prg = $this->prg();
        
        $customer = $this->getCustomerService()
            ->setUser($this->identity())
            ->getCustomerDetailsFromUserId();

        // Get Voucher from session
        
        /* @var $form \Zend\Form\Form */
        $form = $this->getServiceLocator()
            ->get('FormElementManager')
            ->get('ShopOrderConfirm');

        $form->init();

        $inputFilter = $this->getServiceLocator()
            ->get('InputFilterManager')
            ->get('Shop\InputFilter\Order\Confirm');

        $form->setInputFilter($inputFilter);

        $viewModel = new ViewModel([
            'countryId' => $customer->getDeliveryAddress()->getCountryId(),
            'form' => $form
        ]);

        if ($this->getRequest()->isXmlHttpRequest()) {
            $viewModel->setTerminal(true);
        }

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            $this->getService('ShopCart')->checkStock();

            $messages = $this->getService('ShopCart')->getMessages();

            if (!empty($messages)) {
                $this->flashMessenger()->addInfoMessage(
                    join('<br>', $messages)
                );
            }

            return $viewModel;
        }

        $collect = (isset($prg['collect_instore'])) ? 1 : 0;

        $prg['collect_instore'] = $collect;

        $form->setData($prg);

        if ($form->isValid()) {
            $formValues = $form->getData();
            $orderId    = $this->getOrderService()->create($customer, $formValues);

            if ($orderId) {
                $this->getService('ShopCart')->checkStock(true);

                $messages = $this->getService('ShopCart')->getMessages();

                if (!empty($messages)) {
                    $this->flashMessenger()->addInfoMessage(
                        join('<br>', $messages)
                    );
                }

                $this->getOrderService()->processOrderFromCart($orderId);
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

                return $this->redirect()->toRoute('shop/payment/default', [
                    'paymentOption' => lcfirst($action)
                ]);
            }
        }

        $this->getService('ShopCart')->checkStock();

        $messages = $this->getService('ShopCart')->getMessages();

        if (!empty($messages)) {
            $this->flashMessenger()->addInfoMessage(
                join('<br>', $messages)
            );
        }

        return $viewModel;
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
        $form = $this->getService('FormElementManager')
            ->get('UthandoUserRegister', [
                'returnTo' => 'shop/checkout'
            ]);
        return $form;
    }
}