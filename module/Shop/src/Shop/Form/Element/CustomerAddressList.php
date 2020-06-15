<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Element;

use Shop\Service\CustomerAddressService;
use Common\Service\ServiceManager;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class CustomerAddressList
 *
 * @package Shop\Form\Element
 */
class CustomerAddressList extends Select implements ServiceLocatorAwareInterface
{
    
    use ServiceLocatorAwareTrait;
    
    protected $customerId;
    
    public function setOptions($options)
    {
    	parent::setOptions($options);
    
    	if (isset($this->options['customer_id'])) {
    		$this->setCustomerId($this->options['customer_id']);
    	}
    }
    
    public function getValueOptions()
    {
    	return ($this->valueOptions) ?: $this->getAddresses();
    }
    
    public function getAddresses()
    {
        $addresses = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(CustomerAddressService::class)
            ->getAllAddressesByCustomerId($this->getCustomerId());
        
        $addressOptions = [
            0 => '---Please select an address---',
        ];

        /* @var $address \Shop\Model\CustomerAddressModel */
        foreach($addresses as $address) {
            $addressLabel = join(', ', [
                $address->getAddress1(),
                $address->getPostcode(),
            ]);
        	$addressOptions[] = [
        	   'label' => $addressLabel,
        	   'value' => $address->getCustomerAddressId(),
        	];
        }
        
        return $addressOptions;
    }
    
    /**
     * @return int $customerId
     */
    public function getCustomerId()
    {
    	return $this->customerId;
    }
    
    /**
     * @param int $customerId
     * @return \Shop\Form\Element\CustomerAddressList
     */
    public function setCustomerId($customerId)
    {
    	$this->customerId = (int) $customerId;
    	return $this;
    }

}
