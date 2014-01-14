<?php
namespace Shop\Service;

use Application\Service\AbstractService;

class Customer extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\Customer';
    protected $form = 'Shop\Form\Customer\Customer';
    protected $inputFilter = 'Shop\InputFilter\Customer';
    
    public function getBillingAddress($userId)
    {
        return $this->getMapper()->getBillingAddress($userId);
    }
    
    public function getDeliveryAddress($userId)
    {
        return $this->getMapper()->getDeliveryAddress($userId);
    }
    
    public function searchCustomers(array $post)
    {
    	$customer = (isset($post['customer'])) ? (string) $post['customer'] : '';
    	$address = (isset($post['address'])) ? (string) $post['address'] : '';
    	$sort = (isset($post['sort'])) ? (string) $post['sort'] : '';
    	 
    	//$this->getMapper()->useModelRelationships(true);
    	 
    	$customers = $this->getMapper()->searchCustomers($customer, $address, $sort);
    	 
    	return $customers;
    }
}
