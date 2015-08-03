<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Payment
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Payment;

use UthandoCommon\Service\AbstractService;
use Zend\View\Model\ViewModel;
use Shop\Model\Payment\CreditCard as CreditCardModel;

/**
 * Class CreditCard
 *
 * @package Shop\Service\Payment
 */
class CreditCard extends AbstractService
{
    protected $serviceAlias = "ShopPaymentCreditCard";
    
    public function process(array $data)
    {
        $country = $this->getService('ShopCountry')->getById($data['address']['countryId']);
        
        $this->setFormOptions([
            'billing_country' => $country->getCode(),
        ]);
        $model = $this->getModel();
        $form = $this->getForm($model, $data, true, true);
        
        if (!$form->isValid()) {
            return $form;
        }
        
        $model = $form->getData();
        
        $address = $this->getService('ShopCustomerAddress');
        
        $modelAddress = $address->populate($model->getAddress(), true);
        $model->setAddress($modelAddress);
        
        $this->sendEmail($model);
        
        return true;
    }
    
    public function sendEmail(CreditCardModel $model)
    {
        /* @var $orderService \Shop\Service\Order\Order */
        $orderService = $this->getService('ShopOrder');
        
        $order = $orderService->getById($model->getOrderId());
        $orderService->populate($order, true);
        
        $email = $order->getCustomer()->getEmail();
    
        $emailView = new ViewModel([
            'order' => $order,
            'card' => $model,
        ]);
    
        $emailView->setTemplate('shop/payment/credit-card');
    
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
            'transport'        => 'default',
        ]);
    }
}