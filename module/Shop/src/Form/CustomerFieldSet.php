<?php

namespace Shop\Form;

use Common\Filter\Ucwords;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Fieldset;
use Shop\Model\CustomerModel;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Hydrator\ClassMethods;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\StringLength;

/**
 * Class CustomerFieldSet
 *
 * @package Shop\Form
 */
class CustomerFieldSet extends Fieldset implements InputFilterProviderInterface
{
    use CustomerTrait;

    /**
     * @var int
     */
    protected $country;
    
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods(false))
            ->setObject(new CustomerModel());
    }
    
    public function initElements()
    {
        $this->addElements();

        $this->add([
            'type' => CustomerAddressFieldSet::class,
            'name' => 'billingAddress',
            'options' => [
                'label' => 'Billing Address',
                'country' => $this->getOption('billing_country'),
            ],
        ]);

        $this->get('billingAddress')->initElements();
        
        $this->add([
            'type' => CustomerAddressFieldSet::class,
            'name' => 'deliveryAddress',
            'options' => [
                'label' => 'Delivery Address',
                'country' => $this->getOption('delivery_country'),
            ],
        ]);

        $this->get('deliveryAddress')->initElements();
    }
    
    public function getInputFilterSpecification()
    {
        return[
            'prefixId' => [
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
            
            'firstname' => [
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Ucwords::class],
                ],
                'validators' => [
                    ['name'    => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => 2,
                        'max'      => 255,
                    ]],
                ],
            ],
            
            'lastname' => [
                'required'   => true,
                'filters'    => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Ucwords::class],
                ],
                'validators' => [
                    ['name'    => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => 2,
                        'max'      => 255,
                    ]],
                ],
            ],
            
            'email' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
        ];
    }
}
