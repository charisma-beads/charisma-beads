<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

/**
 * Class Confirm
 *
 * @package Shop\InputFilter
 */
class OrderConfirmInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
        	'name' => 'payment_option',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => NotEmpty::class, 'options' => [
                    'messages' => [
                        NotEmpty::IS_EMPTY => 'Please choose a payment option to continue.',
                    ]
                ]],
            ]
        ]);
        
        $this->add([
            'name' => 'requirements',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);
        
        $this->add([
            'name' => 'terms',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => NotEmpty::class, 'options' => [
                    'messages' => [
                        NotEmpty::IS_EMPTY => 'You must agree to the terms to proceed with order.',
                    ]
                ]],
            ]
        ]);
    }
}
