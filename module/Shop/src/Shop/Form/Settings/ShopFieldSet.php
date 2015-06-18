<?php
namespace Shop\Form\Settings;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use Shop\Options\ShopOptions;
use Zend\Stdlib\Hydrator\ClassMethods;

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
            'name'			=> 'alert',
            'type'			=> 'checkbox',
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
            'name' => 'alertText',
            'type' => 'textarea',
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
            'name' => 'productsPerPage',
            'type' => 'number',
            'options' => [
                'label' => 'Products Per Page',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'productsOrderCol',
            'type' => 'text',
            'options' => [
                'label' => 'Product Sort Order',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name'			=> 'postState',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Enable Postage',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'stockControl',
            'type'			=> 'checkbox',
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
            'name'			=> 'vatState',
            'type'			=> 'checkbox',
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
            'name' => 'vatNumber',
            'type' => 'text',
            'options' => [
                'label' => 'VAT Number',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name'			=> 'autoIncrementCart',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Auto Increment Cart',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
    }
    
    public function getInputFilterSpecification()
    {
        return [
            'alertText' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],
            'productsPerPage' => [
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    ['name' => 'Int'],
                ],
            ],
            'productsOrderCol' => [
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],
            'vatNumber' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],
        ];
    }
}
