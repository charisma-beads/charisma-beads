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
        
        $customer = $customerService->getCustomerDetailsFromUserId($data['userId']);
        
        $customer->setFirstname($data['firstname'])
            ->setLastname($data['lastname'])
            ->setEmail($data['email'])
            ->setDateModified();
        
        $result = $customerService->save($customer);
    }
    
    public static function userAdd(Event $e)
    {
        $sl = $e->getTarget()->getServiceLocator();
        $data = $e->getParams();
        
        /* @var $customerService \Shop\Service\Customer */
        $customerService = $sl->get('Shop\Service\Customer');
        
        $customer = $customerService->getMapper()->getModel($data);
        
        $result = $customerService->save($customer);
    }
}
