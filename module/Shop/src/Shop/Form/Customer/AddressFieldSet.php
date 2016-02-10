<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Customer;

use Shop\Model\Country\Country;
use Shop\Model\Customer\Address as AddressModel;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class AddressFieldSet
 *
 * @package Shop\Form\Customer
 */
class AddressFieldSet extends Fieldset implements InputFilterProviderInterface
{
    use AddressTrait;
    
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods(false))
            ->setObject(new AddressModel());
    }
    
    public function initElements()
    {
        $this->addElements();
    }
    
    public function getInputFilterSpecification()
    {
        $countryCode = $this->getOption('country');

        if ($countryCode instanceof Country) {
            $countryCode = ($countryCode->getCode()) ? $countryCode->getCode() : 'GB';
        }

        return [
            'address1' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                    ['name' => 'UthandoUcwords'],
                ],
                'validators' => [
                    ['name' => 'NotEmpty'],
                ],
            ],
            
            'address2' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                    ['name' => 'UthandoUcwords'],
                ],
                'validators' => [
                    ['name' => 'NotEmpty'],
                ],
            ],
            
            'address3' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                    ['name' => 'UthandoUcwords'],
                ],
                'validators' => [
                    ['name' => 'NotEmpty'],
                ],
            ],
            
            'city' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                    ['name' => 'UthandoUcwords'],
                ],
                'validators' => [
                    ['name' => 'NotEmpty'],
                ],
            ],
            
            'provinceId' => [
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
            ],
            
            'postcode' => [
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
            ],
            
            'countryId' => [
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
            ],
            
            'phone' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                    ['name' => 'Digits'],
                    ['name' => 'UthandoCommonPhoneNumber', 'options' => [
                        'country' => $countryCode,
                    ]],
                ],
                'validators' => [
                    ['name' => 'UthandoCommonPhoneNumber', 'options' => [
                        'country' => $countryCode,
                    ]],
                ],
            ],
        ];
    }
}
