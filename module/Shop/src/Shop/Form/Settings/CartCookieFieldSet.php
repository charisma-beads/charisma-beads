<?php
namespace Shop\Form\Settings;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;
use Shop\Options\CartCookieOptions;

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
     * @see \Zend\Form\Element::init()
     */
    public function init()
    {
        $this->add([
            'name' => 'expiry',
            'type' => 'number',
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
            'type' => 'text',
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
            'type'			=> 'checkbox',
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
            'type' => 'text',
            'options' => [
                'label' => 'Url',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'cookieName',
            'type' => 'text',
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
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    ['name' => 'Int'],
                ],
            ],
            'domain' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],
            'url' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],
            'cookieName' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],
        ];
    }
}
