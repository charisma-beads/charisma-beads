<?php

namespace Shop\Service;

use Shop\Form\CustomerAddressForm;
use Shop\Hydrator\CustomerAddressHydrator;
use Shop\InputFilter\CustomerAddressInputFilter;
use Shop\Mapper\CustomerAddressMapper;
use Shop\Model\CustomerAddressModel;
use Shop\ShopException;
use Common\Service\AbstractRelationalMapperService;
use Laminas\EventManager\Event;

/**
 * Class Address
 *
 * @package Shop\Service
 */
class CustomerAddressService extends AbstractRelationalMapperService
{
    protected $form         = CustomerAddressForm::class;
    protected $hydrator     = CustomerAddressHydrator::class;
    protected $inputFilter  = CustomerAddressInputFilter::class;
    protected $mapper       = CustomerAddressMapper::class;
    protected $model        = CustomerAddressModel::class;
    
    protected $tags = [
        'customer-address', 'country', 'country-province',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'country'           => [
            'refCol'    => 'countryId',
            'service'   => CountryService::class,
        ],
        'province'   => [
            'refCol'    => 'provinceId',
            'service'   => CountryProvinceService::class,
        ],
    ];
    
    /**
     * (non-PHPdoc)
     * @see \Common\Service\AbstractService::attachEvents()
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
     * @return array|mixed|\Common\Model\ModelInterface
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
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
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
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function getAllAddressesByCustomerId($customerId)
    {
        $customerId = (int) $customerId;

        /* @var $mapper \Shop\Mapper\CustomerAddressMapper */
        $mapper = $this->getMapper();

        $addresses = $mapper->getAllByCustomerId($customerId);
        
        foreach ($addresses as $address) {
        	$this->populate($address, true);
        }
        
        return $addresses;
    }

    /**
     * @param int $userId
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function getAllUserAddresses($userId)
    {
        $userId = (int) $userId;

        /* @var $service CustomerService */
        $service = $this->getService(CustomerService::class);
        
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

        /* @var $mapper \Shop\Mapper\CustomerAddressMapper */
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
    
        /* @var $service CountryService */
        $service = $this->getService(CountryService::class);
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