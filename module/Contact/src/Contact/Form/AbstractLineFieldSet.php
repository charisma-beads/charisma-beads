<?php

namespace Contact\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Contact\Model\AbstractLine;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;


class AbstractLineFieldSet extends Fieldset implements InputFilterProviderInterface
{
    /**
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = [])
    {
        if (is_array($name)) {
            $options = $name;
            $name = $options['name'] ?? null;
        }
        
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new AbstractLine());
    }

    /**
     * Setup elements
     */
    public function init()
    {
        $this->add([
            'name' => 'label',
            'type' => Text::class,
            'options' => [
                'label' => 'Label',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'text',
            'type' => Text::class,
            'options' => [
                'label' => 'Text',
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
    public function getInputFilterSpecification(): array
    {
        return [
            'label' => [
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
            'text' => [
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
        ];
    }
}
