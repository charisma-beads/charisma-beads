<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Settings
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Settings;

use Shop\Options\ReportsOptions;
use Shop\Service\Report;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Hydrator\ClassMethods;

/**
 * Class ReportsFieldSet
 *
 * @package Shop\Form\Settings
 */
class ReportsFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new ReportsOptions());
    }

    public function init()
    {
        $this->add([
            'name' => 'memory_limit',
            'type' => Text::class,
            'options' => [
                'label' => 'Reports Memory Limit',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'help-block' => 'If left blank will be the default PHP memory limit which is: ' . ini_get('memory_limit'),
            ],
        ]);

        $this->add([
            'name' => 'month_format',
            'type' => Select::class,
            'options' => [
                'label' => 'Month Format',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'value_options' => [
                    'F' => 'Full Textual Month',
                    'M' => 'Short Textual Month',
                    'm' => 'Numeric Month',
                ],
                'column-size' => 'md-8',
            ],
        ]);

        $this->add([
            'name' => 'writer_type',
            'type' => Select::class,
            'options' => [
                'label' => 'Writer Type',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'value_options' => Report::$writerTypeMap,
                'column-size' => 'md-8',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'memory_limit' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'month_format' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'writer_type' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
        ];
    }
}