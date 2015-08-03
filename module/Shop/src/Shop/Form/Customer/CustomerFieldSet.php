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

use Zend\Form\Fieldset;
use Shop\Model\Customer\Customer as CustomerModel;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class CustomerFieldSet
 *
 * @package Shop\Form\Customer
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
    
    public function init()
    {
        $this->addElements();
        
        $this->add([
            'type' => 'ShopAddressFieldSet',
            'name' => 'billingAddress',
            'options' => [
                'label' => 'Billing Address',
            ],
        ]);
        
        $this->add([
            'type' => 'ShopAddressFieldSet',
            'name' => 'deliveryAddress',
            'options' => [
                'label' => 'Delivery Address',
            ],
        ]);
    }
    
    public function getInputFilterSpecification()
    {
        $this->get('billingAddress')->setOption('country', $this->getOption('billing_country'));
        $this->get('deliveryAddress')->setOption('country', $this->getOption('delivery_country'));
        
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
