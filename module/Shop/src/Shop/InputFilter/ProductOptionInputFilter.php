<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use Zend\Filter\Digits;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsFloat;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

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