<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Form;

use Shop\Model\CountryModel;
use Shop\Model\CustomerAddressModel;
use Common\Filter\Ucwords;
use Common\I18n\Filter\PhoneNumber;
use Common\I18n\Validator\PhoneNumber as PhoneNumberValidator;
use Common\I18n\Validator\PostCode;
use Zend\Filter\Digits;
use Zend\Filter\StringToUpper;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Fieldset;
use Zend\I18n\Filter\Alnum;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Hydrator\ClassMethods;
use Zend\Validator\GreaterThan;
use Zend\Validator\NotEmpty;

/**
 * Class AddressFieldSet
 *
 * @package Shop\Form
 */
class CustomerAddressFieldSet extends Fieldset implements InputFilterProviderInterface
{
    use CustomerAddressTrait;
    
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods(false))
            ->setObject(new CustomerAddressModel());
    }
    
    public function initElements()
    {
        $this->addElements();
    }
    
    public function getInputFilterSpecification()
    {
        $countryCode = $this->getOption('country');

        if ($countryCode instanceof CountryModel) {
            $countryCode = ($countryCode->getCode()) ? $countryCode->getCode() : 'GB';
        }

        return [
            'address1' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Ucwords::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                ],
            ],
            
            'address2' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Ucwords::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                ],
            ],
            
            'address3' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Ucwords::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                ],
            ],
            
            'city' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Ucwords::class],
                ],
                'validators' => [
                    ['name' => NotEmpty::class],
                ],
            ],
            
            'provinceId' => [
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
            ],
            
            'postcode' => [
                'required' => ($countryCode == 'IE') ? false : true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => StringToUpper::class],
                    ['name' => Alnum::class, 'options' => [
                        'allowWhiteSpace' => true,
                    ]],
                ],
                'validators' => [
                    ['name' => PostCode::class, 'options' => [
                        'country' => $countryCode,
                    ]],
                ],
            ],
            
            'countryId' => [
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
            ],
            
            'phone' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Digits::class],
                    ['name' => PhoneNumber::class, 'options' => [
                        'country' => $countryCode,
                    ]],
                ],
                'validators' => [
                    ['name' => PhoneNumberValidator::class, 'options' => [
                        'country' => $countryCode,
                    ]],
                ],
            ],
        ];
    }
}
