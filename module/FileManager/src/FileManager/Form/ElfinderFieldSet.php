<?php

declare(strict_types=1);

namespace FileManager\Form;

use FileManager\Hydrator\Strategy\ArrayToIniStrategy;
use FileManager\Options\ElfinderOptions;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\ClassMethods;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator\StringLength;

class ElfinderFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $hydrator = new ClassMethods();
        $hydrator->addStrategy('server_options', new ArrayToIniStrategy());
        $this->setObject(new ElfinderOptions())
            ->setHydrator($hydrator);
    }

    public function init(): void
    {
        $this->add([
            'name' => 'server_options',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Server Config',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
            'attributes' => [
                'rows' => 50,
            ]
        ]);

        $object         = $this->getObject();
        $hydrator       = $this->getHydrator();
        $defaultOptions = $hydrator->extract($object);

        foreach ($defaultOptions as $key => $value) {
            if ($this->has($key)) {
                $this->get($key)->setValue($value);
            }
        }
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'server_options' => [
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
        ];
    }
}
