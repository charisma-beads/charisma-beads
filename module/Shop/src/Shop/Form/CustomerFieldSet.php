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

use Common\Filter\Ucwords;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Fieldset;
use Shop\Model\CustomerModel;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Hydrator\ClassMethods;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

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
