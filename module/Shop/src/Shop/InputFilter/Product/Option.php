<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Product;

use Zend\InputFilter\InputFilter;

/**
 * Class Option
 *
 * @package Shop\InputFilter\Product
 */
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

        $this->add([
            'name'         => 'productId',
            'required'     => false,
            'filters'      => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'Digits'],
            ],
        ]);

        $this->add([
            'name'         => 'option',
            'required'     => true,
            'filters'      => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators'   => [
                ['name' => 'StringLength', 'options' => [
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
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators'	=> [
                ['name' => 'Float']
            ],
        ]);

        $this->add([
            'name'			=> 'discountPercent',
            'required'		=> true,
            'filters'		=> [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators'	=> [
                ['name' => 'Float'],
                ['name' => 'Between', 'options' => [
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
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators'	=> [
                ['name' => 'Int'],
                ['name' => 'GreaterThan', 'options' => [
                    'min' => 0,
                ]],
            ],
        ]);
    }
} 