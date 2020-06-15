<?php

namespace Twitter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Twitter\Option\TwitterOptions;
use Zend\Filter\Boolean;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Number;
use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Digits;
use Zend\Validator\StringLength;

class TwitterFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->setObject(new TwitterOptions())
            ->setHydrator(new ClassMethods());
    }

    public function init()
    {
        $this->add([
            'name' => 'screen_name',
            'type' => Text::class,
            'options' => [
                'label' => 'Screen Name',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'username',
            'type' => Text::class,
            'options' => [
                'label' => 'User Name',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'display_limit',
            'type' => Number::class,
            'options' => [
                'label' => 'Display Limit',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'type' => Checkbox::class,
            'name' => 'show_direct_tweets',
            'options' => [
                'label' => 'Show Direct Tweets',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'use_hidden_element' => true,
                'required' => false,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'type' => Checkbox::class,
            'name' => 'show_retweets',
            'options' => [
                'label' => 'Show Retweets',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'use_hidden_element' => true,
                'required' => false,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'type' => Checkbox::class,
            'name' => 'show_tweet_links',
            'options' => [
                'label' => 'Show Tweet Links',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'use_hidden_element' => true,
                'required' => false,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'type' => Checkbox::class,
            'name' => 'show_profile_pic',
            'options' => [
                'label' => 'Show Profile Pic',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'use_hidden_element' => true,
                'required' => false,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'type' => OauthOptionsFieldSet::class,
            'name' => 'oauth_options',
            'options' => [
                'label' => 'Twitter Oauth Options',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-12',
            ],
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'screen_name' => [
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
            'username' => [
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
            'display_limit' => [
                'required'      => true,
                'filters'       => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => ToInt::class],
                ],
                'validators'    => [
                    ['name' => Digits::class],
                ],
            ],
            'show_direct_tweets' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StringTrim::class],
                    ['name' => StripTags::class,],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'show_retweets' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StringTrim::class],
                    ['name' => StripTags::class,],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'show_tweet_links' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StringTrim::class],
                    ['name' => StripTags::class,],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'show_profile_pic' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StringTrim::class],
                    ['name' => StripTags::class,],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
        ];
    }
}