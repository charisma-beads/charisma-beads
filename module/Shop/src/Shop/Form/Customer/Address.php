<?php
namespace Shop\Form\Customer;

use Zend\Form\Form;

class Address extends Form
{	
    public function init()
    {
        $this->add([
            'name'  => 'customerAddressId',
            'type'  => 'hidden',
        ]);
        
        $this->add([
        	'name'  => 'customerId',
        	'type'  => 'hidden',
        ]);
        
        $this->add([
        	'name' => 'address1',
        	'type'  => 'text',
        	'attributes' => [
        		'placeholder'    => 'Address Line 1:',
        		'autofocus'      => true,
        	    'autocapitalize' => 'words',
                'required'      => true,
        	],
        	'options' => [
        		'label' => 'Address Line 1:',
        	],
        ]);
        
        $this->add([
        	'name' => 'address2',
        	'type'  => 'text',
        	'attributes' => [
        		'placeholder'      => 'Address Line 2:',
        		'autofocus'        => true,
        	    'autocapitalize'   => 'words'
        	],
        	'options' => [
        		'label' => 'Address Line 2:',
        	],
        ]);
        
        $this->add([
        	'name' => 'address3',
        	'type'  => 'text',
        	'attributes' => [
        		'placeholder'     => 'Address Line 3:',
        		'autofocus'       => true,
        	    'autocapitalize'  => 'words'
        	],
        	'options' => [
        		'label' => 'Address Line 3:',
        	],
        ]);
        
        $this->add([
        	'name' => 'city',
        	'type'  => 'text',
        	'attributes' => [
        		'placeholder'     => 'City\Town:',
        		'autofocus'       => true,
        	    'autocapitalize'  => 'words',
                'required'      => true,
        	],
        	'options' => [
        		'label' => 'City\Town:',
        	],
        ]);
        
        $this->add([
            'name' => 'provinceId',
            'type'  => 'CountryProvinceList',
            'attributes' => [
                'id'       => 'provinceId',
                'required' => true,
            ],
            'options' => [
                'label' => 'County\Province:',
                'country_id' => 1,
            ],
		]);
                
        $this->add([
        	'name' => 'postcode',
        	'type'  => 'text',
        	'attributes' => [
        		'placeholder'       => 'PostCode:',
        		'autofocus'         => true,
        	    'autocapitalize'	=> 'characters',
                'required'      => true,
        	],
        	'options' => [
        		'label' => 'Postcode:',
        	],
        ]);
        
        $this->add([
        	'name' => 'countryId',
        	'type' => 'CountryList',
            'attributes' => [
                'id' => 'countryId',
                'required'      => true,
            ],
        	'options' => [
        		'label' => 'Country',
                'country_id' => 1,
        	],
        ]);
        
        $this->add([
        	'name'			=> 'phone',
        	'type'			=> 'text',
        	'attributes'	=> [
        		'placeholder'	=> 'Phone No.:',
        		'autofocus'		=> true,
        		'required'      => true,
        	],
        	'options'		=> [
        		'label' => 'Phone No.:',
        	],
        ]);
        
        $this->add([
        	'name' => 'dateCreated',
        	'type' => 'hidden',
        ]);
        
        $this->add([
        	'name' => 'dateModified',
        	'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'returnTo',
            'type' => 'hidden',
        ]);
    }
}
