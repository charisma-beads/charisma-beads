<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\StringLength;

/**
 * Class Size
 *
 * @package Shop\InputFilter
 */
class ProductSizeInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'productSizeId',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => IsInt::class],
            ],
        ]);

        $this->add([
            'name' => 'size',
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => array(
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                )],
            ],
        ]);
    }
} 