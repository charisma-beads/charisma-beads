<?php

declare(strict_types=1);


namespace SessionManager\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use SessionManager\Options\SessionOptions;
use SessionManager\Service\Factory\SessionSaveHandlerFactory;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Select;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;

class SessionOptionsFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new SessionOptions());
    }

    public function init()
    {
        $this->add([
            'name' => 'save_handler',
            'type' => Select::class,
            'options' => [
                'label' => 'Save Path',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'value_options' => [
                    'files'                             => 'PHP',
                    SessionSaveHandlerFactory::class    => 'Data Base'
                ],
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'save_handler' => [
                'filters' => [
                    ['name' => StringTrim::class],
                    ['name' => StripTags::class],
                ],
            ],
        ];
    }
}