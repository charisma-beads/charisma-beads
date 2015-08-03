<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Customer;

use \Shop\Model\Customer\Customer as CustomerModel;
use UthandoCommon\Service\AbstractRelationalMapperService;
use UthandoCommon\Service\ServiceException;
use UthandoUser\Model\User;
use Zend\EventManager\Event;
use Zend\Math\BigInteger\BigInteger;
use Zend\Math\Rand;
use Shop\Form\Customer\CustomerDetails;

/**
 * Class Customer
 *
 * @package Shop\Service\Customer
 * @method CustomerModel populate()
 */
class Customer extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopCustomer';
    
    protected $tags = [
        'customer', 'customer-prefix', 'customer-address',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'user'              => [
            'refCol'    => 'userId',
            'service'   => 'UthandoUser',
        ],
        'prefix'            => [
            'refCol'    => 'prefixId',
            'service'   => 'ShopCustomerPrefix',
        ],
        'deliveryAddress'   => [
            'refCol'    => 'deliveryAddressId',
            'service'   => 'ShopCustomerAddress',
            'getMethod' => 'getFullAddressById',
        ],
        'billingAddress'    => [
            'refCol'    => 'billingAddressId',
            'service'   => 'ShopCustomerAddress',
            'getMethod' => 'getFullAddressById',
        ],
    ];

    /**
     * @var User
     */
    protected $user;

    /**
     * Attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'post.edit'
        ], [$this, 'postEdit']);
        
        $this->getEventManager()->attach([
            'pre.form',
            'post.add'
        ], [$this, 'checkCustomerNumber']);
        
        $this->getEventManager()->attach([
            'pre.add'
        ], [$this, 'setCustomerValidation']);
        
        $this->getEventManager()->attach([
            'form.init'
        ], [$this, 'formInit']);
    }

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

        // no customer is return create one base on the userId.
        if(!$customer instanceof CustomerModel) {
            /* @var \UthandoUser\Service\User $userService */
            $userService = $this->getService('UthandoUser');
            $user = $userService->getById($userId);
            $user = $userService->getMapper()->extract($user);
            $customer = $this->getMapper()->getModel($user);
            $this->save($customer);
        }
        
        $this->populate($customer, true);
        
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

        $customer = $this->getCustomerByUserId($userId);
        
        $this->populate($customer, true);
        
        return $customer;
    }
    
    /**
     * @param CustomerDetails $form
     * @param array $data
     * @return CustomerDetails|int|null
     */
    public function updateCustomerDetails(CustomerDetails $form, array $data)
    {
        if ($data['shipToBilling'] == 1) {
            $data['customer']['deliveryAddress'] = $data['customer']['billingAddress'];
        }

        $form->get('customer')
            ->get('deliveryAddress')
            ->get('provinceId')
            ->setCountryId($data['customer']['deliveryAddress']['countryId']);

        $form->get('customer')
            ->get('billingAddress')
            ->get('provinceId')
            ->setCountryId($data['customer']['billingAddress']['countryId']);
        
        $form->setData($data);
        
        if (!$form->isValid()) {
            return $form;
        }
        
        /* @var $customer \Shop\Model\Customer\Customer */
        $customer = $form->getData();
        
        $customerId = $customer->getCustomerId();
        
        // not customer yet
        if (!$customerId) {
            $customerId = $this->add($customer->getArrayCopy());
            $customer->setCustomerId($customerId);
        }
        
        if (!$customer->getBillingAddress()->getCustomerId()) {
            $customer->getBillingAddress()->setCustomerId($customerId);
        }
        
        if (!$customer->getDeliveryAddress()->getCustomerId()) {
            $customer->getDeliveryAddress()->setCustomerId($customerId);
        }
        
        // add or update billing a delivery address
        /* @var $customerAddressService \Shop\Service\Customer\Address */
        $customerAddressService = $this->getService('ShopCustomerAddress');
        
        $saveBillingAddress = $customerAddressService->save($customer->getBillingAddress());
        
        $billingAddressId = ($customer->getBillingAddressId()) ?: $saveBillingAddress;
        
        if ($data['shipToBilling'] == 0) {
            $saveDeliveryAddress = $customerAddressService->save($customer->getDeliveryAddress());
            $deliveryAddressId = ($customer->getDeliveryAddressId()) ?: $saveDeliveryAddress;
        } else {
            $deliveryAddressId = $billingAddressId;
        }
        
        $customer->setBillingAddressId($billingAddressId)
            ->setDeliveryAddressId($deliveryAddressId);
        
        return $this->edit($customer, $customer->getArrayCopy());
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
        
        foreach($customers as $customer) {
            $this->populate($customer, true);
        }

        return $customers;
    }

    /**
     * Update or set customer default address for billing or delivery.
     *
     * @param array $post
     * @return int
     * @throws ServiceException
     */
    public function setCustomerAddress(array $post)
    {
        $id = (isset($post['customerId'])) ? (int) $post['customerId'] : null;

        $form = $this->getForm($this->getById($id), $post, true, true);
        $form->setValidationGroup(array_keys($post));

        if (!$form->isValid()) {
            throw new ServiceException('values not valid');
        }

        return $this->save($form->getData());
    }

    /**
     * Generate a customer number with check digit at end
     * to test use simple test:
     *
     * $pass = ($checkDigit === substr($num, 0, -1) % 11 % 10) ? true : false
     *
     * @param CustomerModel $customer
     * @return string
     */
    public function generateCustomerNumber(CustomerModel $customer)
    {
        $part1 = $customer->getDateCreated()->format('Y');
        $part2 = sprintf('%06d', $customer->getCustomerId());;
        $part3 = Rand::getString(5, '0123456789');

        $num = join('', [
            $part1, $part2, $part3
        ]);

        $bigInt = BigInteger::factory('bcmath');
        $checkDigit = $bigInt->mod($num, 11);
        $checkDigit = $bigInt->mod($checkDigit, 10);

        return $num . $checkDigit;
    }
    
    /**
     * Set billing and delivery customerId
     * 
     * @param Event $e
     */
    public function formInit(Event $e)
    {
        $form = $e->getParam('form');
        $model = $e->getParam('model');
        
        if ($model instanceof CustomerModel) {
            $customerId = $model->getCustomerId();
            $form->get('billingAddressId')->setCustomerId($customerId);
            $form->get('deliveryAddressId')->setCustomerId($customerId);
        }
    }

    /**
     * @param Event $e
     */
    public function postEdit(Event $e)
    {
        /* @var CustomerModel $model */
        $model = $e->getParam('model');

        $this->populate($model, ['user']);

        $user = $model->getUser();

        if ($user->getFirstname() != $model->getFirstname() ||
            $user->getLastname() != $model->getLastname() ||
            $user->getEmail() != $model->getEmail()) {

            /* @var \UthandoUser\Service\User $userService */
            $userService = $this->getService('UthandoUser');
            $post = $user->getArrayCopy();

            $post['firstname'] = $model->getFirstname();
            $post['lastname'] = $model->getLastname();
            $post['email'] = $model->getEmail();

            $userService->edit($user, $post);
        }
    }
    
    /**
     * Set validation on customer forms.
     * 
     * @param Event $e
     */
    public function setCustomerValidation(Event $e)
    {
        $form = $e->getParam('form');
        $form->setValidationGroup('prefixId', 'firstname', 'lastname', 'email');
    }
    
    /**
     * BC add customer numbers as we go.
     *
     * @param Event $e
     * @return CustomerModel
     */
    public function checkCustomerNumber(Event $e)
    {
        $model = $e->getParam('model');
        $insertId = $e->getParam('saved');
    
        if (!$model && $insertId) {
            $model = $this->getById($insertId);
        }
        
        if (!$model instanceof CustomerModel) {
            return $model;
        }
    
        if (!$model->getNumber() && $model->getCustomerId()) {
            $cusNum = $this->generateCustomerNumber($model);
            $model->setNumber($cusNum);
            $this->save($model);
            $model = $this->getById($model->getCustomerId());
        }
    
        return $model;
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
