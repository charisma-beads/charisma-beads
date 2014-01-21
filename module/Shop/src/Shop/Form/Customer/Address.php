<?php
namespace Shop\Form\Customer;

use Application\Form\AbstractForm;

class Address extends AbstractForm
{
    public function init()
    {   
        $this->add(array(
            'name'  => 'customerAddressId',
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
        	'name' => 'county',
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
        	'name' => 'country',
        	'type' => 'select',
        	'options' => array(
        		'label' => 'Country',
        		'required' => true,
        		'empty_option' => '---Please select a country---',
        		'value_options' => $this->getCountryList()
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'phone',
        	'type'			=> 'tel',
        	'attributes'	=> array(
        		'placeholder'	=> 'Phone No.:',
        		'autofocus'		=> true,
        		'required'      => true,
        	),
        	'options'		=> array(
        		'label' => 'Phone No.:',
        	),
        ));
        
        $this->add(array(
        	'name'			=> 'email',
        	'type'			=> 'email',
        	'attributes'	=> array(
        		'placeholder'	=> 'Email:',
        		'autofocus'		=> true,
        		'required'		=> true,
        	),
        	'options'		=> array(
        		'label'	=> 'Email',
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
    
    public function getCountryList()
    {
        $countries = $this->getCountryService()->fetchAll();
        $countryOptions = array();
         
        foreach($countries as $country) {
        	$countryOptions[$country->getCountryId()] = $country->getCountry();
        }
        
        return $countryOptions;
    }
    
    /**
     * @return \Shop\Service\Country
     */
    public function getCountryService()
    {
    	return $this->getServiceLocator()->get('Shop\Service\Country');
    }
}
