<?php

namespace Contact\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Common\Hydrator\Strategy\CollectionToArrayStrategy;
use Contact\Options\FormOptions;
use Laminas\Filter\Boolean;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element\Collection;
use Laminas\Form\Element\Radio;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\ClassMethods;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator\StringLength;


class FormFieldSet extends Fieldset implements InputFilterProviderInterface
{
    /**
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = [])
    {
        if (is_array($name)) {
            $options = $name;
            $name = (isset($options['name'])) ? $options['name'] : null;
        }

        parent::__construct($name, $options);

        $hydrator = new ClassMethods();
        $hydrator->addStrategy('transport_list', new CollectionToArrayStrategy());

        $this->setHydrator($hydrator)
            ->setObject(new FormOptions());
    }

    public function init()
    {
        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Form Name',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'type' => Collection::class,
            'name' => 'transport_list',
            'options' => [
                'label' => 'Transport List',
                'label_options' => [
                    'disable_html_escape' => true,
                ],
                'count' => 0,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => [
                    'type' => AbstractLineFieldSet::class,
                ],
            ],
            'attributes' => [
                'class' => 'col-md-12',
            ],
        ]);

        $this->add([
            'name' => 'send_copy_to_sender',
            'type' => Radio::class,
            'options' => [
                'label' => 'Send Copy to Sender',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'value_options' => [
                    [
                        'value' => 0,
                        'label' => 'No',
                        'label_attributes' => [
                            'class' => 'col-md-12',
                        ],

                    ],
                    [
                        'value' => 1,
                        'label' => 'Yes',
                        'label_attributes' => [
                            'class' => 'col-md-12',
                        ],

                    ],
                ],
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'enable_captcha',
            'type' => Radio::class,
            'options' => [
                'label' => 'Enable Captcha',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'value_options' => [
                    [
                        'value' => 0,
                        'label' => 'No',
                        'label_attributes' => [
                            'class' => 'col-md-12',
                        ],

                    ],
                    [
                        'value' => 1,
                        'label' => 'Yes',
                        'label_attributes' => [
                            'class' => 'col-md-12',
                        ],

                    ],
                ],
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification(): array
    {
        return [
            'name' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 255,
                    ]],
                ],
            ],
            'send_copy_to_sender' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class],
                ],
            ],
            'enable_captcha' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class],
                ],
            ],
        ];
    }
}
