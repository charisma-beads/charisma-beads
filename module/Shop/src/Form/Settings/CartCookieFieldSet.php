<?php

namespace Shop\Form\Settings;

use Laminas\Filter\Boolean;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Text;
use Laminas\Hydrator\ClassMethods;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use Shop\Options\CartCookieOptions;

/**
 * Class CartCookieFieldSet
 *
 * @package Shop\Form\Settings
 */
class CartCookieFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods())
        ->setObject(new CartCookieOptions());
    }
    
    /**
     * 'cart_cookie'       => [
            'expiry'            => 60*60*24,
            'domain'            => '',
            'secure'            => 0,
            'url'               => '/',
            'cookieName'        => 'CBShoppingCart',
        ],
     * 
     * (non-PHPdoc)
     * @see \Laminas\Form\Element::init()
     */
    public function init()
    {
        $this->add([
            'name' => 'expiry',
            'type' => Number::class,
            'options' => [
                'label' => 'Expiry Time',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'help-block' => 'This is the number of seconds the cart will expire.',
            ],
        ]);
        
        $this->add([
            'name' => 'domain',
            'type' => Text::class,
            'options' => [
                'label' => 'Domain',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name'			=> 'secure',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Secure',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);
        
        $this->add([
            'name' => 'url',
            'type' => Text::class,
            'options' => [
                'label' => 'Url',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'cookie_name',
            'type' => Text::class,
            'options' => [
                'label' => 'Cookie Name',
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
            'expiry' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ],
            'domain' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'secure' => [
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
            'url' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'cookie_name' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
        ];
    }
}
