<?php
namespace Shop\Service\Customer;

use Application\Service\AbstractService;

class Address extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\CustomerAddress';
    protected $form = 'Shop\Form\CustomerAddress';
    protected $inputFilter = 'Shop\InputFilter\CustomerAddress';
    
    public function getBillingAddressByUserId($userId)
    {
        return $this->getMapper()->getBillingAddressByUserId($userId);
    }
    
    public function getDeliveryAddressByUserId($userId)
    {
        return $this->getMapper()->getDeliveryAddressByUserId($userId);
    }
}