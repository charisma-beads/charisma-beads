<?php

namespace Shop\InputFilter;

use Laminas\Filter\Digits;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsFloat;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Between;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\StringLength;

/**
 * Class Option
 *
 * @package Shop\InputFilter
 */
class ProductOptionInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'         => 'productOptionId',
            'required'     => false,
            'filters'      => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Digits::class],
            ],
        ]);

        $this->add([
            'name'         => 'productId',
            'required'     => false,
            'filters'      => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Digits::class],
            ],
        ]);

        $this->add([
            'name'         => 'option',
            'required'     => true,
            'filters'      => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'   => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 100,
                ]],
            ],
        ]);

        $this->add([
            'name'			=> 'price',
            'required'		=> true,
            'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'	=> [
                ['name' => IsFloat::class]
            ],
        ]);

        $this->add([
            'name'			=> 'discountPercent',
            'required'		=> true,
            'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'	=> [
                ['name' => IsFloat::class],
                ['name' => Between::class, 'options' => [
                    'min'		=> 0,
                    'max'		=> 100,
                    'inclusive'	=> true,
                ]],
            ],
        ]);

        $this->add([
            'name'			=> 'postUnitId',
            'required'		=> true,
            'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'	=> [
                ['name' => IsInt::class],
                ['name' => GreaterThan::class, 'options' => [
                    'min' => 0,
                ]],
            ],
        ]);
    }
} 