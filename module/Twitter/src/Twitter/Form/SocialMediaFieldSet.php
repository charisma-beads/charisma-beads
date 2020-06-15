<?php

namespace Twitter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Twitter\Event\AutoPostListener;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Checkbox;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;

class SocialMediaFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function init()
    {
        $this->add([
            'type' => Checkbox::class,
            'name' => 'twitter',
            'options' => [
                'label' => 'Twitter',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'required' => false,
                'checked_value' => AutoPostListener::EVENT_TWITTER_STATUS,
                'column-size' => 'md-12',
            ],
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'twitter' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StringTrim::class],
                    ['name' => StripTags::class],
                ],
                'validators'    => [
                    ['name' => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                        'max' => 255
                    ]],
                ],
            ],
        ];
    }
}