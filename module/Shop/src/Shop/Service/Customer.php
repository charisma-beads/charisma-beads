<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class Customer extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Customer';
    protected $form = 'Shop\Form\Customer';
    protected $inputFilter = 'Shop\InputFilter\Customer';
    
    public function getBillingAddress($userId)
    {
        return $this->getMapper()->getBillingAddress($userId);
    }
    
    public function getDeliveryAddress($userId)
    {
        return $this->getMapper()->getDeliveryAddress($userId);
    }
}
