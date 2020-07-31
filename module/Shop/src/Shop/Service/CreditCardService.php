<?php

namespace Shop\Service;

use Shop\Form\CreditCardForm;
use Shop\Hydrator\CreditCardHydrator;
use Shop\InputFilter\CreditCardInputFilter;
use Shop\Options\OrderOptions;
use Common\Service\AbstractService;
use Laminas\View\Model\ViewModel;
use Shop\Model\CreditCardModel;

/**
 * Class CreditCard
 *
 * @package Shop\Service
 */
class CreditCardService extends AbstractService
{
    protected $form         = CreditCardForm::class;
    protected $hydrator     = CreditCardHydrator::class;
    protected $inputFilter  = CreditCardInputFilter::class;
    protected $model        = CreditCardModel::class;
    
    public function process(array $data)
    {
        $country = $this->getService(CountryService::class)->getById($data['address']['countryId']);
        
        $this->setFormOptions([
            'billing_country' => $country->getCode(),
        ]);

        $model = $this->getModel();
        $form = $this->prepareForm($model, $data, true, true);
        
        if (!$form->isValid()) {
            return $form;
        }
        
        $model = $form->getData();
        
        $address = $this->getService(CustomerAddressService::class);
        
        $modelAddress = $address->populate($model->getAddress(), true);
        $model->setAddress($modelAddress);
        
        $this->sendEmail($model);
        
        return true;
    }
    
    public function sendEmail(CreditCardModel $model)
    {
        /* @var $orderService \Shop\Service\OrderService */
        $orderService = $this->getService(OrderService::class);

        /* @var $options \Shop\Options\OrderOptions */
        $options = $this->getService(OrderOptions::class);
        
        $order = $orderService->getById($model->getOrderId());
        $orderService->populate($order, true);
        
        $email = $order->getCustomer()->getEmail();
    
        $emailView = new ViewModel([
            'order' => $order,
            'card' => $model,
        ]);
    
        $emailView->setTemplate('shop/email/credit-card-email-body');
    
        $this->getEventManager()->trigger('mail.send', $this, [
            'sender'        => [
                'name'      => $order->getCustomer()->getFullName(),
                'address'   => $email,
            ],
            'layout'           => 'shop/email/credit-card',
            'layout_params'    => [
                'order' => $order,
            ],
            'body'             => $emailView,
            'subject'          => 'Order No.:' . $order->getOrderNumber(),
            'transport'        => $options->getCreditCardPaymentEmail(),
        ]);
    }
}