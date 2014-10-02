<?php
namespace Shop\Service\Customer;

use UthandoCommon\Service\AbstractRelationalMapperService;

class Address extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopCustomerAddress';

    /**
     * @var array
     */
    protected $referenceMap = [
        'country'           => [
            'refCol'    => 'countryId',
            'service'   => 'Shop\Service\Country',
        ],
        'province'   => [
            'refCol'    => 'provinceId',
            'service'   => 'Shop\Service\Country\Province',
        ],
    ];

    /**
     * @param int $id
     * @return array|mixed|\UthandoCommon\Model\ModelInterface
     */
    public function getFullAddressById($id)
    {
        $id = (int) $id;
        $address = $this->getById($id);
        
        $this->populate($address, true);
        
        return $address;
    }

    /**
     * @param array $post
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     * @throws ShopException
     */
    public function search(array $post)
    {
        if (!isset($post['customerId'])) {
            throw new ShopException('customerId needs to be set.');
        }

        return $this->getAllAddressesByCustomerId($post['customerId']);
    }

    /**
     * @param int $customerId
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getAllAddressesByCustomerId($customerId)
    {
        $customerId = (int) $customerId;

        /* @var $mapper \Shop\Mapper\Customer\Address */
        $mapper = $this->getMapper();

        $addresses = $mapper->getAllByCustomerId($customerId);
        
        foreach ($addresses as $address) {
        	$this->populate($address, true);
        }
        
        return $addresses;
    }

    /**
     * @param int $userId
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getAllUserAddresses($userId)
    {
        $userId = (int) $userId;

        /* @var $service \Shop\Mapper\Customer\Customer */
        $service = $this->getService('Shop\Service\Customer');
        
        $customerId = $service
            ->getCustomerByUserId($userId)
            ->getCustomerId();
        
        return $this->getAllAddressesByCustomerId($customerId);
    }

    /**
     * @param int $userId
     * @param string $billingOrDelivery
     * @return array|\ArrayObject|null|object
     */
    public function getAddressByUserId($userId, $billingOrDelivery)
    {
        $userId = (int) $userId;
        $billingOrDelivery = (string) $billingOrDelivery;

        /* @var $mapper \Shop\Mapper\Customer\Address */
        $mapper = $this->getMapper();
    
        $address = $mapper->getAddressByUserId($userId, $billingOrDelivery);
        $this->populate($address, true);
    
        return $address;
    }
}