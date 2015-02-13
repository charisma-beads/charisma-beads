<?php
namespace Shop\Form\Customer;

use Zend\Form\Fieldset;
use Shop\Model\Customer\Customer as CustomerModel;
use Shop\Hydrator\Customer\Customer as CustomerHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

class CustomerFieldSet extends Fieldset implements InputFilterProviderInterface
{
    use CustomerTrait;
    
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new CustomerHydrator())
            ->setObject(new CustomerModel());
    }
    
    public function init()
    {
        $this->addElements();
    }
    
    public function getInputFilterSpecification()
    {
        return[
            'prefixId' => [
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
            
            'firstname' => [
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
            ],
            
            'lastname' => [
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
            ],
            
            'email' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
            
                ],
            ],
        ];
    }
}
