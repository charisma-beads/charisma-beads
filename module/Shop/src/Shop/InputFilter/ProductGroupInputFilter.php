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

use Zend\Filter\StringToUpper;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsFloat;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

/**
 * Class Group
 *
 * @package Shop\InputFilter
 */
class ProductGroupInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'       => 'group',
            'required'   => true,
            'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => StringToUpper::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 1,
                    'max'      => 5,
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
    }    
}
