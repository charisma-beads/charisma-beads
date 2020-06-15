<?php

namespace Newsletter\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;


class TemplateInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'templateId',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'utf-8',
                    'max' => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'params',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name' => 'body',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
            ],
        ]);
    }
}