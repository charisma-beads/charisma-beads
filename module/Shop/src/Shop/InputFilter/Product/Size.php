<?php
/**
 * Created by PhpStorm.
 * User: shaun
 * Date: 18/11/14
 * Time: 14:29
 */

namespace Shop\InputFilter\Product;

use Zend\InputFilter\InputFilter;

class Size extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'productSizeId',
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'Int'],
            ],
        ]);

        $this->add([
            'name' => 'size',
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
            ],
            'validators' => [
                ['name' => 'StringLength', 'options' => array(
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                )],
            ],
        ]);
    }
} 