<?php

namespace FileManager\Form;

use FileManager\Options\FileManagerOptions;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\ClassMethods;
use Laminas\InputFilter\InputFilterProviderInterface;

class LegacyFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->setObject(new FileManagerOptions())
            ->setHydrator(new ClassMethods());
    }

    public function init()
    {
        $this->add([
            'name'			=> 'case_sensitive',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Case Sensitive',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'name' => 'default_file_type',
            'type' => Text::class,
            'options' => [
                'label' => 'Default File Type',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'default_file_type',
            'type' => Text::class,
            'options' => [
                'label' => 'Default File Type',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'convert_to_default',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Convert To Default',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'name' => 'max_width',
            'type' => Number::class,
            'options' => [
                'label' => 'Max Width',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'max_height',
            'type' => Number::class,
            'options' => [
                'label' => 'Max Height',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'use_max',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Use Max',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'name' => 'min_width',
            'type' => Number::class,
            'options' => [
                'label' => 'Min Width',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'min_height',
            'type' => Number::class,
            'options' => [
                'label' => 'Min Height',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'use_min',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Use Min',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'name'			=> 'resize_over_sized',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Resize Over Sized',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'name' => 'default_file_permissions',
            'type' => Text::class,
            'options' => [
                'label' => 'Default File Permissions',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'destination',
            'type' => Text::class,
            'options' => [
                'label' => 'Destination',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'overwrite',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Overwrite',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'name'			=> 'create_thumbnail',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Create Thumbnail',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'name' => 'thumbnail_directory',
            'type' => Text::class,
            'options' => [
                'label' => 'Thumbnail Directory',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'thumbnail_width',
            'type' => Number::class,
            'options' => [
                'label' => 'Thumbnail Width',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'thumbnail_height',
            'type' => Number::class,
            'options' => [
                'label' => 'Thumbnail Height',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }
}
