<?php

namespace Shop\InputFilter;

use Common\Filter\Ucwords;
use Laminas\Filter\StringToUpper;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\StringLength;

/**
 * Class Province
 *
 * @package Shop\InputFilter
 */
class CountryProvinceInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'countryId',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => IsInt::class],
            ],
        ]);

        $this->add([
            'name'       => 'provinceCode',
            'required'   => true,
            'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => StringToUpper::class],
            ],
            'validators' => [
                array('name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 1,
                    'max'      => 10,
                ]),
            ],
        ]);

        $this->add([
            'name'       => 'provinceName',
            'required'   => true,
            'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Ucwords::class],
            ],
            'validators' => [
                array('name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]),
            ],
        ]);

        $this->add([
            'name'       => 'provinceAlternateNames',
            'required'   => false,
            'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Ucwords::class],
            ],
            'validators' => [
                array('name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]),
            ],
        ]);
    }
}
