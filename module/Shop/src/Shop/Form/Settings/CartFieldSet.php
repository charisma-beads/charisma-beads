<?php

namespace Shop\Form\Settings;


use Laminas\Filter\Boolean;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Radio;
use Laminas\Hydrator\ClassMethods;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use Shop\Options\CartOptions;

/**
 * Class CartFieldSet
 *
 * @package Shop\Form\Settings
 */
class CartFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods())
            ->setObject(new CartOptions());
    }
    
    public function init()
    {
        
        $this->add([
            'name'			=> 'pay_check',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Cheque Payments',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'pay_phone',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Phone Payments',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'pay_credit_card',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Credit Card Payments',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'pay_paypal',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Paypal Payments',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'collect_instore',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Collect Instore',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);

        $this->add([
            'name'			=> 'auto_increment_cart',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Auto Increment Cart',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);

        $this->add([
            'name'			=> 'shipping_by_weight',
            'type'			=> Radio::class,
            'options'		=> [
                'label'			=> 'Shipping Cost',
                'value_options' => [
                    [
                        'value' => '0',
                        'label' => 'By Invoice Value',
                        'label_attributes' => [
                            'class' => 'col-md-12',
                        ],

                    ],
                    [
                        'value' => '1',
                        'label' => 'By Invoice Weight',
                        'label_attributes' => [
                            'class' => 'col-md-12',
                        ],

                    ],
                ],
                'required' 		=> true,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }
    
    public function getInputFilterSpecification()
    {
        return [
            'pay_check' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'pay_phone' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'pay_credit_card' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'pay_paypal' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'collect_instore' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'auto_increment_cart' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'shipping_by_weight' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
        ];
    }
}
