<?php
namespace Shop\Service\Customer;

use Shop\ShopException;
use UthandoCommon\Service\AbstractRelationalMapperService;
use Zend\EventManager\Event;

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
            'service'   => 'ShopCountry',
        ],
        'province'   => [
            'refCol'    => 'provinceId',
            'service'   => 'ShopCountryProvince',
        ],
    ];
    
    /**
     * (non-PHPdoc)
     * @see \UthandoCommon\Service\AbstractService::attachEvents()
     */
    public function attachEvents()
    {   
        $this->getEventManager()->attach([
            'form.init'
        ], [$this, 'customerAddressForm']);
        
        $this->getEventManager()->attach([
            'pre.add',
            'pre.edit'
        ], [$this, 'setCountryValidation']);
        
    }

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
        $service = $this->getService('ShopCustomer');
        
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

        if ($address) {
            $this->populate($address, true);
        }

        return $address;
    }
    
    public function setCountryValidation(Event $e)
    {
        $form = $e->getParam('form');
        $post = $e->getParam('post');
    
        /* @var $service \Shop\Service\Country\Country */
        $service = $this->getService('ShopCountry');
        $countryId = $post['countryId'];
    
        $country = $service->getById($countryId);
    
        $validator = $form->getInputFilter();
    
        $validator->setCountryCode($country->getCode());
        $validator->remove('phone');
        $validator->remove('postcode');
        $validator->init();
    }
    
    public function customerAddressForm(Event $e)
    {
        $form = $e->getParam('form');
        $data = $e->getParam('data');
        $model = $e->getParam('model');
        
        if (isset($data['countryId'])) {
            $countryId = $data['countryId'];
        } elseif ($model) {
            $countryId = $model->getCountryId();
        } else {
            $countryId = $form->get('countryId')->getCountryId();
        }
         
        $form->get('provinceId')->setCountryId($countryId);
    }
}