<?php
namespace Shop\Event;

use Zend\EventManager\Event;

class UserEvent
{
    public static function userEdit(Event $e)
    {
        $sl = $e->getTarget()->getServiceLocator();
        $data = $e->getParams();
        /* @var $customerService \Shop\Service\Customer */
        $customerService = $sl->get('Shop\Service\Customer');
        /* $var $addressService \Shop\Service\Customer\Address */
        $addressService = $sl->get('Shop\Service\CustomerAddress');
        \FB::info($data);
        
        $customer = $customerService->getCustomerDetailsFromUserId($data['userId']);
        $address = $customer->getBillingAddress();
        \FB::info($customer);
        
        $customer->setFirstname($data['firstname'])
            ->setLastname($data['lastname'])
            ->setDateModified();
        
        $address->setEmail($data['email'])
            ->setDateModified();
        
        $result1 = $customerService->save($customer);
        $result2 = $addressService->save($address);
        
        \FB::info($customer);
        \FB::info($result1);
        \FB::info($result2);
    }
}
