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

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

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