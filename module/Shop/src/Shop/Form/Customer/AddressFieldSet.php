<?php
namespace Shop\Form\Customer;

use Shop\Model\Customer\Address as AddressModel;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class AddressFieldSet extends Fieldset implements InputFilterProviderInterface
{
    use AddressTrait;
    
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods(false))
            ->setObject(new AddressModel());
    }
    
    public function init()
    {
        $this->addElements();
    }
    
    public function getInputFilterSpecification()
    {
        return [
            'address1' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
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
                        'country' => $this->getOption('country'),
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
                    ['name' => 'UthandoPhoneNumber', 'options' => [
                        'country' => $this->getOption('country'),
                    ]],
                ],
                'validators' => [
                    ['name' => 'PhoneNumber', 'options' => [
                        'country' => $this->getOption('country'),
                    ]],
                ],
            ],
        ];
    }
}
