<?php
namespace Shop\Service\Customer;

use UthandoCommon\Service\AbstractMapperService;
use UthandoUser\Model\User;

class Customer extends AbstractMapperService
{
    protected $mapperClass = 'Shop\Mapper\Customer';
    protected $form = 'Shop\Form\Customer';
    protected $inputFilter = 'Shop\InputFilter\Customer\Customer';

    protected $serviceAlias = 'ShopCustomer';
    
    /**
     * @var User
     */
    protected $user;
    
    /**
     * @var \User\Service\User
     */
    protected $userService;
    
    /**
     * @var \Shop\Service\Customer\Prefix
     */
    protected $customerPrefixService;
    
    /**
     * @var \Shop\Service\Customer\Address
     */
    protected $customerAddressService;
    
    /**
     * @param string $userId
     * @return \Shop\Model\Customer
     */
    public function getCustomerByUserId($userId)
    {
        $userId = (int) $userId;
        
        $customer = $this->getMapper()->getCustomerByUserId($userId);
        
        return $customer;
    }
    
    /**
     * @param int $id
     * @return \Shop\Model\Customer
     */
    public function getCustomerDetailsByCustomerId($id)
    {
        $customer = $this->getById($id);
        
        $this->populate($customer, true);
        
        return $customer;
    }
    
    /**
     * @return \Shop\Model\Customer
     */
    public function getCustomerDetailsFromUserId($userId = null)
    {
        $userId = ($userId) ? $userId : $this->getUser()->getUserId();
        $customer = $this->getMapper()->getCustomerByUserId($userId);
        
        $this->populate($customer, true);
        
        return $customer;
    }
    
    /**
     * @param $model \Shop\Model\Customer
     * @param $children boolean|array
     */
    public function populate($model, $children = false)
    {
        $allChildren = ($children === true) ? true : false;
        $children = (is_array($children)) ? $children : array();
        
        if ($allChildren || in_array('user', $children)) {
            if ($this->getUser() instanceof User) {
                $model->setUser($this->getUser());
            } else {
                $model->setUser(
                    $this->getUserService()
                        ->getById($model->getUserId())
                );
            }
        }
        
        if ($allChildren || in_array('prefix', $children)) {
            $model->setPrefix(
                $this->getCustomerPrefixService()
                    ->getById($model->getPrefixId())
            );
        }
        
        if ($allChildren || in_array('deliveryAddress', $children)) {
            $model->setDeliveryAddress(
                $this->getCustomerAddressService()
                    ->getFullAddressById($model->getDeliveryAddressId())
            );
        }
        
        if ($allChildren || in_array('billingAddress', $children)) {
            $model->setBillingAddress(
                $this->getCustomerAddressService()
                    ->getFullAddressById($model->getBillingAddressId())
            );
        }
    }
    
    /**
     * @return \User\Model\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return \Shop\Service\Customer
     */
	public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

	/**
     * @return \User\Service\User
     */
    public function getUserService()
    {
        if (!$this->userService) {
            $sl = $this->getServiceLocator();
            $this->userService = $sl->get('UthandoUser\Service\User');
        }
    
        return $this->userService;
    }
    
    /**
     * @return \Shop\Service\Customer\Address
     */
    public function getCustomerAddressService()
    {
        if (!$this->customerAddressService) {
            $sl = $this->getServiceLocator();
            $this->customerAddressService = $sl->get('Shop\Service\Customer\Address');
        }
    
        return $this->customerAddressService;
    }
    
    /**
     * @return \Shop\Service\Customer\Prefix
     */
    public function getCustomerPrefixService()
    {
        if (!$this->customerPrefixService) {
            $sl = $this->getServiceLocator();
            $this->customerPrefixService = $sl->get('Shop\Service\Customer\Prefix');
        }
    
        return $this->customerPrefixService;
    }
}
