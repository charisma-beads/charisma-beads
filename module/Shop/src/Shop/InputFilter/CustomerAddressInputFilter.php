<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use Shop\I18n\Validator\PostCode;
use Common\Filter\Ucwords;
use Common\I18n\Filter\PhoneNumber;
use Zend\Filter\Digits;
use Zend\Filter\StringToUpper;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\GreaterThan;
use Zend\Validator\NotEmpty;

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
