<?php
namespace Shop\Service\Payment;

use UthandoCommon\Service\AbstractService;
use Shop\Form\Payment\CreditCard as CreditCardForm;

class CreditCard extends AbstractService
{
    protected $serviceAlias = "ShopPaymentCreditCard";
    
    public function process(CreditCardForm $form)
    {
        
    }
}