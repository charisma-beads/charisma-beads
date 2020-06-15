<?php

namespace Twitter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;

class TwitterOauthOptionsFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function init()
    {
        $this->add([
            'name' => 'consumerKey',
            'type' => Text::class,
            'options' => [
                'label' => 'Consumer Key',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'consumerSecret',
            'type' => Text::class,
            'options' => [
                'label' => 'Comsumer Secret',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'consumerKey' => [
                'required'      => true,
                'filters'       => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators'    => [
                    ['name' => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 255
                    ]],
                ],
            ],
            'consumerSecret' => [
                'required'      => true,
                'filters'       => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators'    => [
                    ['name' => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 255
                    ]],
                ],
            ],
        ];
    }
}