<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class CustomerAddress extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\CustomerAddress';
    protected $form = 'Shop\Form\Customer\Address';
    protected $inputFilter = 'Shop\InputFilter\Customer\Address';
    
    public function getBillingAddress($userId)
    {
        return $this->getMapper()->getCustomerBillingAddress($userId);
    }
}
