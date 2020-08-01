<?php

namespace Shop\Form\Settings;

use Shop\Options\InvoiceOptions;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Stdlib\Hydrator\ClassMethods;

/**
 * Class InvoiceFieldSet
 *
 * @package Shop\Form\Settings
 */
class InvoiceFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new InvoiceOptions());
    }

    public function init()
    {
        $this->add([
            'name' => 'font_size',
            'type' => Text::class,
            'options' => [
                'label' => 'Font Size',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'help-block' => 'Can be any css font-size value (eg. px,pt or %)',
            ],
        ]);

        $this->add([
            'name' => 'panel_title_font_size',
            'type' => Text::class,
            'options' => [
                'label' => 'Panel Title Font Size',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'help-block' => 'Can be any css font-size value (eg. px,pt or %)',
            ],
        ]);

        $this->add([
            'name' => 'footer_font_size',
            'type' => Text::class,
            'options' => [
                'label' => 'Footer Font Size',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'help-block' => 'Can be any css font-size value (eg. px,pt or %)',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'font_size' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'panel_title_font_size' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'footer_font_size' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
        ];
    }
}