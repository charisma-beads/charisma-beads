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
 * Class Size
 *
 * @package Shop\InputFilter\Product
 */
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