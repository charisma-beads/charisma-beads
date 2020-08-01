<?php

declare(strict_types=1);

namespace ThemeManager\InputFilter;

use Common\Filter\Slug;
use Common\InputFilter\NoRecordExistsTrait;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;
use Laminas\Validator\StringLength;

class WidgetInputFilter extends InputFilter implements ServiceLocatorAwareInterface
{
    use NoRecordExistsTrait,
        ServiceLocatorAwareTrait;

    public function init()
    {
        $this->add([
            'name'  => 'widgetId',
            'required'  => false,
            'filters'   => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => ToInt::class],
            ],
            'validators'    => [
                ['name' => IsInt::class],
            ],
        ]);

        $this->add([
            'name'  => 'widgetGroupId',
            'required'  => true,
            'filters'   => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => ToInt::class],
            ],
            'validators'    => [
                ['name' => IsInt::class],
            ],
        ]);

        $this->add([
            'name'  => 'enabled',
            'required'  => true,
            'filters'   => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => ToInt::class],
            ],
        ]);

        $this->add([
            'name'  => 'title',
            'required'  => true,
            'filters'   => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'    => [
                ['name' => StringLength::class, 'options' => [
                    'encoding'  => 'UTF-8',
                    'min'       => 5,
                    'max'       => 255,
                ]],
            ],
        ]);

        $this->add([
            'name'  => 'showTitle',
            'required'  => true,
            'filters'   => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => ToInt::class],
            ],
        ]);

        $this->add([
            'name'  => 'name',
            'required'  => true,
            'filters'   => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Slug::class],
            ],
            'validators'    => [
                ['name' => StringLength::class, 'options' => [
                    'encoding'  => 'UTF-8',
                    'min'       => 5,
                    'max'       => 255,
                ]],
            ],
        ]);

        $this->add([
            'name'  => 'widget',
            'required'  => true,
            'filters'   => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'    => [
                ['name' => StringLength::class, 'options' => [
                    'encoding'  => 'UTF-8',
                    'min'       => 5,
                    'max'       => 255,
                ]],
            ],
        ]);

        $this->add([
            'name'  => 'sortOrder',
            'required'  => false,
            'filters'   => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => ToInt::class],
            ],
            'validators' => [
                ['name' => IsInt::class],
            ],
        ]);

        $this->add([
            'name'  => 'params',
            'required'  => false,
            'filters'   => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
                    'encoding'  => 'UTF-8',
                    'max'       => 1000,
                ]],
            ],
        ]);

        $this->add([
            'name'  => 'html',
            'required'  => false,
            'filters'   => [
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
                    'encoding'  => 'UTF-8',
                    'max'       => 5000,
                ]],
            ],
        ]);
    }
}
