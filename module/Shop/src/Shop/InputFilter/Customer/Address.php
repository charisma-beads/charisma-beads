<?php
namespace Shop\InputFilter\Customer;

use Zend\InputFilter\InputFilter;

class Address extends InputFilter
{
    /**
     * @var string
     */
    protected $countryCode;
    
    public function init()
    {
        $this->add([
    		'name' => 'customerAddressId',
    		'required' => false,
    		'filters' => [
        		['name' => 'StripTags'],
        		['name' => 'StringTrim'],
    		],
    		'validators' => [
        		['name' => 'Int'],
    		],
		]);
        
        $this->add([
    		'name' => 'address1',
    		'required' => true,
    		'filters' => [
        		['name' => 'StripTags'],
        		['name' => 'StringTrim'],
    		    ['name' => 'UthandoUcwords'],
    		],
    		'validators' => [
        		['name' => 'NotEmpty'],
    		],
		]);
        
        $this->add([
    		'name' => 'address2',
    		'required' => false,
    		'filters' => [
        		['name' => 'StripTags'],
        		['name' => 'StringTrim'],
    		    ['name' => 'UthandoUcwords'],
    		],
    		'validators' => [
        		['name' => 'NotEmpty'],
    		],
		]);
        
        $this->add([
    		'name' => 'address3',
    		'required' => false,
    		'filters' => [
        		['name' => 'StripTags'],
        		['name' => 'StringTrim'],
    		    ['name' => 'UthandoUcwords'],
    		],
    		'validators' => [
        		['name' => 'NotEmpty'],
    		],
		]);
        
        $this->add([
            'name' => 'city',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'UthandoUcwords'],
            ],
            'validators' => [
                ['name' => 'NotEmpty'],
            ],
        ]);
        
        $this->add([
    		'name' => 'provinceId',
    		'required' => true,
    		'filters' => [
        		['name' => 'StripTags'],
        		['name' => 'StringTrim'],
    		],
    		'validators' => [
        		['name' => 'Int'],
        		['name' => 'GreaterThan', 'options' => [
                    'min' => 0,
                ]],
    		],
		]);

        $countryCode = $this->getCountryCode();
        
        $this->add([
    		'name' => 'postcode',
    		'required' => ($countryCode == 'IE') ? false : true,
    		'filters' => [
    		    ['name' => 'StripTags'],
        		['name' => 'StringTrim'],
                ['name' => 'StringToUpper'],
                ['name' => 'Alnum', 'options' => [
                    'allowWhiteSpace' => true,
                ]],
    		],
    		'validators' => [
        		['name' => 'UthandoCommonPostCode', 'options' => [
                    'country' => $countryCode,
                ]],
    		],
		]);
        
        $this->add([
    		'name' => 'countryId',
    		'required' => true,
    		'filters' => [
        		['name' => 'StripTags'],
        		['name' => 'StringTrim'],
    		],
    		'validators' => [
        		['name' => 'Int'],
        		['name' => 'GreaterThan', 'options' => [
                    'min' => 0,
        		]],
    		],
		]);
        
        $this->add([
    		'name' => 'phone',
    		'required' => true,
    		'filters' => [
        		['name' => 'StripTags'],
        		['name' => 'StringTrim'],
                ['name' => 'Digits'],
    		    ['name' => 'UthandoCommonPhoneNumber', 'options' => [
    		        'country' => $this->getCountryCode(),
    		    ]]
    		],
    		'validators' => [
        		['name' => 'UthandoCommonPhoneNumber', 'options' => [
                    'country' => $this->getCountryCode(),
        		]],
    		],
		]);
    }
    
    /**
     * @return string $countryCode
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     * @return $this
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        return $this;
    }

}
