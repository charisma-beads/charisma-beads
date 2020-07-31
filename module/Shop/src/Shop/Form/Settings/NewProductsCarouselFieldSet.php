<?php

namespace Shop\Form\Settings;

use Shop\Options\NewProductsCarouselOptions;
use Laminas\Filter\Boolean;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\UpperCaseWords;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Text;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\ClassMethods;

/**
 * Class NewProductsCarouselFieldSet
 *
 * @package Shop\Form\Settings
 */
class NewProductsCarouselFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods())
            ->setObject(new NewProductsCarouselOptions());
    }

    public function init()
    {
        $this->add([
            'name' => 'title',
            'type' => Text::class,
            'options' => [
                'label' => 'Title',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'total_items',
            'type' => Text::class,
            'options' => [
                'label' => 'Total Items',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'number_items_to_display',
            'type' => Text::class,
            'options' => [
                'label' => 'Number To Display',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'auto_play',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Auto Play',
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
            'title' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => UpperCaseWords::class]
                ],
            ],
            'total_items' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ],
            'number_items_to_display' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ],
            'auto_play' => [
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
