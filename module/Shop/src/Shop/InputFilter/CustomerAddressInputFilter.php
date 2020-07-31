<?php

namespace Shop\InputFilter;

use Shop\I18n\Validator\PostCode;
use Common\Filter\Ucwords;
use Common\I18n\Filter\PhoneNumber;
use Laminas\Filter\Digits;
use Laminas\Filter\StringToUpper;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\NotEmpty;

/**
 * Class Address
 *
 * @package Shop\InputFilter\Customer
 */
class CustomerAddressInputFilter extends InputFilter
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    		],
    		'validators' => [
        		['name' => IsInt::class],
    		],
		]);
        
        $this->add([
    		'name' => 'address1',
    		'required' => true,
    		'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    		    ['name' => Ucwords::class],
    		],
    		'validators' => [
        		['name' => NotEmpty::class],
    		],
		]);
        
        $this->add([
    		'name' => 'address2',
    		'required' => false,
    		'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    		    ['name' => Ucwords::class],
    		],
    		'validators' => [
        		['name' => NotEmpty::class],
    		],
		]);
        
        $this->add([
    		'name' => 'address3',
    		'required' => false,
    		'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    		    ['name' => Ucwords::class],
    		],
    		'validators' => [
        		['name' => NotEmpty::class],
    		],
		]);
        
        $this->add([
            'name' => 'city',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Ucwords::class],
            ],
            'validators' => [
                ['name' => NotEmpty::class],
            ],
        ]);
        
        $this->add([
    		'name' => 'provinceId',
    		'required' => true,
    		'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    		],
    		'validators' => [
        		['name' => IsInt::class],
        		['name' => GreaterThan::class, 'options' => [
                    'min' => 0,
                ]],
    		],
		]);

        $countryCode = $this->getCountryCode();
        
        $this->add([
    		'name' => 'postcode',
    		'required' => ($countryCode == 'IE') ? false : true,
    		'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => StringToUpper::class],
    		],
    		'validators' => [
        		['name' => PostCode::class, 'options' => [
                    'country' => $countryCode,
                ]],
    		],
		]);
        
        $this->add([
    		'name' => 'countryId',
    		'required' => true,
    		'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    		],
    		'validators' => [
        		['name' => IsInt::class],
        		['name' => GreaterThan::class, 'options' => [
                    'min' => 0,
        		]],
    		],
		]);

        $this->add([
    		'name' => 'phone',
    		'required' => true,
    		'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Digits::class],
    		    ['name' => PhoneNumber::class, 'options' => [
    		        'country' => $this->getCountryCode(),
    		    ]]
    		],
    		'validators' => [
        		['name' => \Common\I18n\Validator\PhoneNumber::class, 'options' => [
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
