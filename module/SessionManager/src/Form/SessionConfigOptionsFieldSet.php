<?php

declare(strict_types=1);


namespace SessionManager\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use SessionManager\Options\SessionConfigOptions;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\ClassMethods;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator\StringLength;

class SessionConfigOptionsFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new SessionConfigOptions());
    }

    public function init()
    {
        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Name',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'save_path',
            'type' => Text::class,
            'options' => [
                'label' => 'Save Path',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'remember_me_seconds',
            'type' => Number::class,
            'options' => [
                'label' => 'Remember Me Seconds',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'cookie_lifetime',
            'type' => Number::class,
            'options' => [
                'label' => 'Cookie Lifetime',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                    ]],
                ],
            ],
            'save_path' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                    ]],
                ],
            ],
            'remember_me_seconds' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ],
            'cookie_lifetime' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ],
        ];
    }
}