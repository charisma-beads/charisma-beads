<?php
namespace Shop\InputFilter\Customer;

use Zend\InputFilter\InputFilter;

class Address extends InputFilter
{
    public function __construct()
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
        
        $this->add([
    		'name' => 'postcode',
    		'required' => true,
    		'filters' => [
    		    ['name' => 'StripTags'],
        		['name' => 'StringTrim'],
                ['name' => 'StringToUpper'],
                ['name' => 'Alnum', 'options' => [
                    'allowWhiteSpace' => true,
                ]],
    		],
    		'validators' => [
        		['name' => 'Shop\I18n\Validator\PostCode', 'options' => [
                    'country' => 'GB',
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
    		],
    		'validators' => [
        		['name' => 'PhoneNumber', 'options' => [
                    'country' => 'GB',
        		]],
    		],
		]);
    }
}
