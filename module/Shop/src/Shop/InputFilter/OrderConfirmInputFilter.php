<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\NotEmpty;

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
