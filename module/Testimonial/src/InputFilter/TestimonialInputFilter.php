<?php

namespace Testimonial\InputFilter;

use Common\Filter\Ucwords;
use Laminas\Filter\Digits;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\StringLength;


class TestimonialInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'testimonialId',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
                ['name' => Digits::class]
            ],
        ]);

        $this->add([
            'name' => 'name',
            'required'      => true,
            'filters'       => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
                ['name' => Ucwords::class],
            ],
            'validators'    => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255
                ]],
            ],
        ]);

        $this->add([
            'name' => 'image',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                ['name'    => StringLength::class,'options' => [
                    'encoding' => 'UTF-8',
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'location',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                ['name'    => StringLength::class,'options' => [
                    'encoding' => 'UTF-8',
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'company',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                ['name'    => StringLength::class,'options' => [
                    'encoding' => 'UTF-8',
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'website',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                ['name'    => StringLength::class,'options' => [
                    'encoding' => 'UTF-8',
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'sector',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                ['name'    => StringLength::class,'options' => [
                    'encoding' => 'UTF-8',
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'text',
            'required'      => true,
            'filters'       => [
                ['name' => StringTrim::class],
            ],
            'validators'    => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                ]],
            ],
        ]);
    }
} 