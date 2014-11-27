<?php
namespace Shop\InputFilter\Country;

use Zend\InputFilter\InputFilter;

class Province extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'countryId',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'Int'],
            ],
        ]);

        $this->add([
            'name'       => 'provinceCode',
            'required'   => true,
            'filters'    => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'StringToUpper'],
            ],
            'validators' => [
                array('name' => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]),
            ],
        ]);

        $this->add([
            'name'       => 'provinceName',
            'required'   => true,
            'filters'    => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'UthandoUcwords'],
            ],
            'validators' => [
                array('name' => 'StringLength', 'options' => [
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
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'UthandoUcwords'],
            ],
            'validators' => [
                array('name' => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]),
            ],
        ]);
    }
}
