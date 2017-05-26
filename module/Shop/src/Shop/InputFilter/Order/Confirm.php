<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Order;

use Shop\Validator\Voucher;
use Zend\Filter\StringToUpper;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Filter\Alnum;
use Zend\I18n\Validator\Alnum as AlnumValidator;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

/**
 * Class Confirm
 *
 * @package Shop\InputFilter\Order
 */
class Confirm extends InputFilter
{
    public function init()
    {
        $this->add([
        	'name' => 'payment_option',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'NotEmpty', 'options' => [
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
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);
        
        $this->add([
            'name' => 'terms',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
            	['name' => 'NotEmpty', 'options' => [
                    'message' => [
                        NotEmpty::IS_EMPTY => 'You must agree to the terms to proceed with order.',
                    ]
                ]],
            ]
        ]);
    }
}
