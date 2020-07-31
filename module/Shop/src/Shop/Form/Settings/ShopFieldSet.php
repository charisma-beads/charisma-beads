<?php

namespace Shop\Form\Settings;

use Laminas\Filter\Boolean;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Hydrator\ClassMethods;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use Shop\Options\ShopOptions;


/**
 * Class ShopFieldSet
 *
 * @package Shop\Form\Settings
 */
class ShopFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods())
            ->setObject(new ShopOptions());
    }
    
    public function init()
    {
        $this->add([
            'name' => 'development_mode',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Development Mode',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);

        $this->add([
            'name' => 'merchant_name',
            'type' => Text::class,
            'options' => [
                'label' => 'Merchant Name',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'alert',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Enable Alert',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name' => 'alert_text',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Alert Text',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
            'attributes' => [
                'row' => 3
            ],
        ]);
        
        $this->add([
            'name' => 'products_per_page',
            'type' => Number::class,
            'options' => [
                'label' => 'Products Per Page',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'products_order_col',
            'type' => Text::class,
            'options' => [
                'label' => 'Product Sort Order',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name'			=> 'stock_control',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Enable Stock Control',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'vat_state',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Enable VAT',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name' => 'vat_number',
            'type' => Text::class,
            'options' => [
                'label' => 'VAT Number',
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
            'development_mode' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'merchant_name' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'alert' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'alert_text' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'products_per_page' => [
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => ToInt::class],
                ],
            ],
            'products_order_col' => [
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'stock_control' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'vat_state' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'vat_number' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
        ];
    }
}
