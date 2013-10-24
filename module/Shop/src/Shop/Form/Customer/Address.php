<?php
namespace Shop\Form\Customer;

use Zend\Form\Form;

//`countryId` int(2) unsigned DEFAULT '0',


class Address extends Form
{
    protected $countryMapper;
    
    public function init()
    {   
        $this->add(array(
            'name'  => 'addressId',
            'type'  => 'hidden',
        ));
        
        $this->add(array(
        	'name'  => 'userId',
        	'type'  => 'hidden',
        ));
        
        $this->add(array(
        	'name' => 'address1',
        	'type'  => 'text',
        	'attributes' => array(
        		'placeholder' => 'Address Line 1:',
        		'autofocus' => true
        	),
        	'options' => array(
        		'label' => 'Address Line 1:',
        	),
        ));
        
        $this->add(array(
        	'name' => 'address2',
        	'type'  => 'text',
        	'attributes' => array(
        		'placeholder' => 'Address Line 2:',
        		'autofocus' => true
        	),
        	'options' => array(
        		'label' => 'Address Line 2:',
        	),
        ));
        
        $this->add(array(
        	'name' => 'address3',
        	'type'  => 'text',
        	'attributes' => array(
        		'placeholder' => 'Address Line 3:',
        		'autofocus' => true
        	),
        	'options' => array(
        		'label' => 'Address Line 3:',
        	),
        ));
        
        $this->add(array(
        	'name' => 'city',
        	'type'  => 'text',
        	'attributes' => array(
        		'placeholder' => 'City\Town:',
        		'autofocus' => true
        	),
        	'options' => array(
        		'label' => 'City\Town:',
        	),
        ));
        
        $this->add(array(
        	'name' => 'address1',
        	'type'  => 'county',
        	'attributes' => array(
        		'placeholder' => 'County:',
        		'autofocus' => true
        	),
        	'options' => array(
        		'label' => 'County:',
        	),
        ));
        
        $this->add(array(
        	'name' => 'address1',
        	'type'  => 'text',
        	'attributes' => array(
        		'placeholder' => 'Address Line 1:',
        		'autofocus' => true
        	),
        	'options' => array(
        		'label' => 'Address Line 1:',
        	),
        ));
        
        $this->add(array(
        	'name' => 'postcode',
        	'type'  => 'text',
        	'attributes' => array(
        		'placeholder' => 'PostCode:',
        		'autofocus' => true
        	),
        	'options' => array(
        		'label' => 'Postcode:',
        	),
        ));
        
        $this->add(array(
        	'name' => 'phone',
        	'type'  => 'tel',
        	'attributes' => array(
        		'placeholder' => 'Phone No.:',
        		'autofocus' => true
        	),
        	'options' => array(
        		'label' => 'Phone No.:',
        	),
        ));
        
        $this->add(array(
        	'name' => 'dateCreated',
        	'type' => 'hidden',
        ));
        
        $this->add(array(
        	'name' => 'dateModified',
        	'type' => 'hidden',
        ));
    }
    
    /**
     * @param \Shop\Mapper\Country $mapper
     */
    public function setCountryMapper($mapper)
    {
    	$this->countryMapper = $mapper;
    }
}
