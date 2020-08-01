<?php

namespace Shop\Controller;

use Shop\Form\CustomerDetailsForm;
use Shop\Form\OrderConfirmForm;
use Shop\InputFilter\OrderConfirmInputFilter;
use Shop\Model\CountryModel;
use Shop\Service\CartService;
use Shop\Service\CountryService;
use Shop\Service\CustomerService;
use Shop\Service\OrderService;
use Common\Service\ServiceTrait;
use User\Form\LoginForm;
use User\Form\RegisterForm;
use Laminas\Filter\Word\UnderscoreToDash;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Session\Container;
use Laminas\Http\PhpEnvironment\Response;
use Laminas\Form\Form;

/**
 * Class Checkout
 *
 * @package Shop\Controller
 */
class CheckoutController extends AbstractActionController
{
    use ServiceTrait;

    /**
     *
     * @var \Shop\Service\CustomerService
     */
    protected $customerService;

    public function indexAction()
    {
        $service = $this->getService(CartService::class);

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
        if (!$this->getService(CartService::class)->hasItems()) {
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
        if (!$this->getService(CartService::class)->hasItems()) {
            return $this->redirect()->toRoute('shop');
        }
        
        $prg = $this->prg();
        
        $userId = $this->identity()->getUserId();
        $customer = $this->getCustomerService()
            ->getCustomerDetailsFromUserId($userId);
        /* @var \Shop\Service\CountryService $countryService */
        $countryService = $this->getService(CountryService::class);

        if (is_array($prg)) {
            $billingCountry = $countryService->getById($prg['customer']['billingAddress']['countryId']);
            $deliveryCountry = $countryService->getById($prg['customer']['deliveryAddress']['countryId']);
        } else {
            $billingCountry = $customer->getBillingAddress()->getCountry();
            $deliveryCountry = $customer->getDeliveryAddress()->getCountry();
        }
        
        $form = $this->getService('FormElementManager')
            ->get(CustomerDetailsForm::class, [
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
                'countryId' => ($billingCountry instanceof CountryModel) ? $billingCountry->getCountryId() : $billingCountry,
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
            'countryId' => ($billingCountry instanceof CountryModel) ? $billingCountry->getCountryId() : $billingCountry,
            'form' => $form,
        ];
        
    }

    public function confirmOrderAction()
    {   
        if (!$this->getService(CartService::class)->hasItems()) {
            return $this->redirect()->toRoute('shop');
        }

        $prg = $this->prg();
        
        $customer = $this->getCustomerService()
            ->setUser($this->identity())
            ->getCustomerDetailsFromUserId();

        // Get Voucher from session
        
        /* @var $form \Laminas\Form\Form */
        $form = $this->getServiceLocator()
            ->get('FormElementManager')
            ->get(OrderConfirmForm::class);

        $form->init();

        $inputFilter = $this->getServiceLocator()
            ->get('InputFilterManager')
            ->get(OrderConfirmInputFilter::class);

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
            $this->getService(CartService::class)->checkStock();

            $messages = $this->getService(CartService::class)->getMessages();

            if (!empty($messages)) {
                foreach ($messages as $message) {
                    $this->flashMessenger()->addInfoMessage($message);
                }
            }

            if (!$this->getService(CartService::class)->hasItems()) {
                $this->getService(CartService::class)->clear(false);
                $viewModel->setTemplate('shop/checkout/cancel-checkout');
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
                $this->getService(CartService::class)->checkStock(true);

                $messages = $this->getService(CartService::class)->getMessages();

                if (!empty($messages)) {
                    foreach ($messages as $message) {
                        $this->flashMessenger()->addInfoMessage($message);
                    }
                }

                if (!$this->getService(CartService::class)->hasItems()) {
                    $this->getService(CartService::class)->clear(false);
                    $viewModel->setTemplate('shop/checkout/cancel-checkout');
                    return $viewModel;
                }

                $this->getOrderService()->processOrderFromCart($orderId);
                $this->getService(CartService::class)->clear(false);

                // need to email order,
                // add params to session and redirect to payment page.
                $orderParams = [
                    'orderId' => $orderId,
                    'collect' => $collect,
                    'requirements' => $formValues['requirements']
                ];

                $filter = new UnderscoreToDash();
                $action = $filter->filter($formValues['payment_option']);

                /* @var $container \Laminas\Session\AbstractContainer */
                $container = new Container('order');
                $container->setExpirationHops(1, null);
                $container->order = $orderParams;

                return $this->redirect()->toRoute('shop/payment/default', [
                    'paymentOption' => lcfirst($action)
                ]);
            }
        }

        $this->getService(CartService::class)->checkStock();

        $messages = $this->getService(CartService::class)->getMessages();

        if (!empty($messages)) {
            foreach ($messages as $message) {
                $this->flashMessenger()->addInfoMessage($message);
            }
        }

        if (!$this->getService(CartService::class)->hasItems()) {
            $this->getService(CartService::class)->clear(false);
            $viewModel->setTemplate('shop/checkout/cancel-checkout');
        }

        return $viewModel;
    }

    public function cancelOrderAction()
    {
        if ($this->request->isPost()) {
            $submit = $this->params()->fromPost('submit', null);
            
            if ('cancelOrder' === $submit) {
                $this->getService(CartService::class)->clear();
                $this->flashmessenger()->addSuccessMessage('You have successfully canceled your order.');
                return $this->redirect()->toRoute('shop');
            }
        }
        
        return $this->redirect()->toRoute('shop');
    }

    /**
     *
     * @return \Shop\Service\CustomerService
     */
    public function getCustomerService()
    {
        if (! $this->customerService) {
            $this->customerService = $this->getService(CustomerService::class);
        }
        
        return $this->customerService;
    }

    /**
     *
     * @return \Shop\Service\OrderService
     */
    protected function getOrderService()
    {
        return $this->getService(OrderService::class);
    }

    public function getLoginForm()
    {
        $form = $this->getService('FormElementManager')
            ->get(LoginForm::class);
        $form->setData(array(
            'returnTo' => 'shop/checkout'
        ));
        return $form;
    }

    public function getRegisterForm()
    {
        $form = $this->getService('FormElementManager')
            ->get(RegisterForm::class, [
                'returnTo' => 'shop/checkout'
            ]);
        return $form;
    }
}