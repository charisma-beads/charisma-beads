<?php
namespace Shop\InputFilter\Customer;

use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Customer extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        $this->add([
            'name' => 'customerId',
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
            'name' => 'userId',
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'Int']
            ],
        ]);
        
        $this->add([
    		'name' => 'prefixId',
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
            'name'       => 'firstname',
            'required'   => true,
            'filters'    => [
                ['name'    => 'StripTags'],
                ['name'    => 'StringTrim'],
                ['name' => 'UthandoUcwords'],
            ],
            'validators' => [
                ['name'    => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]],
            ],
        ]);
        
        $this->add([
            'name'       => 'lastname',
            'required'   => true,
            'filters'    => [
                ['name'    => 'StripTags'],
                ['name'    => 'StringTrim'],
                ['name' => 'UthandoUcwords'],
            ],
            'validators' => [
                ['name'    => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]],
            ],
        ]);
        
        $this->add([
    		'name' => 'billingAddressId',
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
    		'name' => 'deliveryAddressId',
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
            'name' => 'email',
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                
            ],
        ]);
    }
}
