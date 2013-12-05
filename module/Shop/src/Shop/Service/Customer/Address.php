<?php
namespace Shop\Service\Customer;

use Application\Service\AbstractService;

class Address extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Customer\Address';
    protected $form = 'Shop\Form\Customer\Address';
    protected $inputFilter = 'Shop\InputFilter\Customer\Address';
    
    public function getBillingAddress($userId)
    {
        return $this->getMapper()->getUserBillingAddress($userId);
    }
    
    public function getDeliveryAddress($userId)
    {
        return $this->getMapper()->getUserDeliveryAddress($userId);
    }
}
