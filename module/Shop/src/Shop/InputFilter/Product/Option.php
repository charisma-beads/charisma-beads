<?php

namespace Shop\InputFilter\Product;

use Zend\InputFilter\InputFilter;

class Option extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'         => 'productOptionId',
            'required'     => false,
            'filters'      => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'Digits'],
            ],
        ]);

        $this->add(array(
            'name'         => 'productId',
            'required'     => false,
            'filters'      => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
                array('name' => 'Digits'),
            ),
        ));

        $this->add(array(
            'name'         => 'option',
            'required'     => true,
            'filters'      => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators'   => array(
                array('name' => 'StringLength', 'options' => array(
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 100,
                )),
            ),
        ));

        $this->add(array(
            'name'			=> 'price',
            'required'		=> true,
            'filters'		=> array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim')
            ),
            'validators'	=> array(
                array('name' => 'Float')
            ),
        ));

        $this->add(array(
            'name'			=> 'discountPercent',
            'required'		=> true,
            'filters'		=> array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators'	=> array(
                array('name' => 'Float'),
                array('name' => 'Between', 'options' => array(
                    'min'		=> 0,
                    'max'		=> 100,
                    'inclusive'	=> true,
                )),
            ),
        ));

        $this->add(array(
            'name'			=> 'postUnitId',
            'required'		=> true,
            'filters'		=> array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators'	=> array(
                array('name' => 'Int'),
                array('name' => 'GreaterThan', 'options' => array(
                    'min' => 0,
                )),
            ),
        ));
    }
} 