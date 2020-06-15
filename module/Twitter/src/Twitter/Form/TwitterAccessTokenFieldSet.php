<?php

namespace Twitter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;

class TwitterAccessTokenFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function init()
    {
        $this->add([
            'name' => 'token',
            'type' => Text::class,
            'options' => [
                'label' => 'Token',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'secret',
            'type' => Text::class,
            'options' => [
                'label' => 'Secret',
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
            'token' => [
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
            'secret' => [
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