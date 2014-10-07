<?php
namespace Shop\Service\Customer;

use UthandoCommon\Service\AbstractRelationalMapperService;
use UthandoUser\Model\User;

class Customer extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopCustomer';

    /**
     * @var array
     */
    protected $referenceMap = [
        'user'              => [
            'refCol'    => 'userId',
            'service'   => 'UthandoUser\Service\User',
        ],
        'prefix'            => [
            'refCol'    => 'prefixId',
            'service'   => 'Shop\Service\Customer\Prefix',
        ],
        'deliveryAddress'   => [
            'refCol'    => 'deliveryAddressId',
            'service'   => 'Shop\Service\Customer\Address',
            'getMethod' => 'getFullAddressById',
        ],
        'billingAddress'    => [
            'refCol'    => 'billingAddressId',
            'service'   => 'Shop\Service\Customer\Address',
            'getMethod' => 'getFullAddressById',
        ],
    ];

    /**
     * @var User
     */
    protected $user;

    /**
     * @param $userId
     * @return array|\ArrayObject|null|\Shop\Model\Customer\Customer
     */
    public function getCustomerByUserId($userId)
    {
        $userId = (int) $userId;

        /* @var $mapper \Shop\Mapper\Customer\Customer */
        $mapper = $this->getMapper();
        $customer = $mapper->getCustomerByUserId($userId);
        
        return $customer;
    }

    /**
     * @param $id
     * @return array|mixed|\Shop\Model\Customer\Customer
     */
    public function getCustomerDetailsByCustomerId($id)
    {
        $customer = $this->getById($id);
        
        $this->populate($customer, true);
        
        return $customer;
    }

    /**
     * @param null $userId
     * @return array|\ArrayObject|null|\Shop\Model\Customer\Customer
     */
    public function getCustomerDetailsFromUserId($userId = null)
    {
        $userId = ($userId) ? $userId : $this->getUser()->getUserId();

        /* @var $mapper \Shop\Mapper\Customer\Customer */
        $mapper = $this->getMapper();

        $customer = $mapper->getCustomerByUserId($userId);
        
        $this->populate($customer, true);
        
        return $customer;
    }

    /**
     * @param $month
     * @param null $year
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function getCustomersByMonth($month, $year = null)
    {
        $month = (int) $month;
        $year = ($year) ?: date('Y');
        $date = new \DateTime(join('-',[
            $year, $month
        ]));
        $startDate = $date->format('Y-m-01');
        $endDate = $date->format('Y-m-t');

        /* @var $mapper \Shop\Mapper\Customer\Customer */
        $mapper = $this->getMapper();

        $customers = $mapper->getCustomersByDate($startDate, $endDate);

        return $customers;
    }

    /**
     * @return \UthandoUser\Model\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
}
