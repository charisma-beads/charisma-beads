<?php

declare(strict_types=1);

namespace User\Form\Settings;

use User\Options\AuthOptions;
use Laminas\Filter\Boolean;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Hydrator\ClassMethods;

class AuthFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new AuthOptions());
    }

    public function init(): void
    {
        $this->add([
            'name' => 'authenticate_method',
            'type' => Text::class,
            'options' => [
                'label' => 'Authenticate Method',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'credential_treatment',
            'type' => Text::class,
            'options' => [
                'label' => 'Credential Treatment',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'use_fallback_treatment',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Use Fallback Treatment',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' => false,
                'column-size' => 'sm-6 col-sm-offset-6',
            ],
        ]);

        $this->add([
            'name' => 'fallback_credential_treatment',
            'type' => Text::class,
            'options' => [
                'label' => 'Fallback Credential Treatment',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'authenticate_method' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'credential_treatment' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'use_fallback_treatment' => [
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
            'fallback_credential_treatment' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
        ];
    }
}
