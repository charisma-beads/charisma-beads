<?php
namespace Shop\InputFilter\Order;

use Zend\InputFilter\InputFilter;

class Confirm extends InputFilter
{
    public function init()
    {
        $this->add(array(
        	'name' => 'payment_option',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty', 'options' => array(
                    'messages' => array(
                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Please choose a payment option to continue.',
                    )
                )),
            )
        ));
        
        $this->add(array(
            'name' => 'requirements',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
        
        $this->add(array(
            'name' => 'terms',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            	array('name' => 'NotEmpty', 'options' => array(
                    'message' => array(
                        \Zend\Validator\NotEmpty::IS_EMPTY => 'You must agree to the terms to proceed with order.',
                    )
                )),
            )
        ));
    }
}
