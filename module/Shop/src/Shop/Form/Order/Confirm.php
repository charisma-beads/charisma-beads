<?php
namespace Shop\Form\Order;

use Zend\Form\Form;

class Confirm extends Form
{
    public function init()
    {
        $this->add([
            'name'		=> 'payment_option',
            'type'		=> 'PayOptionsList',
            'options'	=> [
                'label'			=> 'Choose Payment Options:',
                'required'		=> true,
                'disable_inarray_validator' => true,
                'label_options' => [
                    'disable_html_escape' => true,
                ],
                'label_attributes' => [
                    'class' => 'radio',
                ],
            ],
            
        ]);
        
        $this->add([
            'name'			=> 'collect_instore',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Collect Instore',
                'required' 		=> false,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
            ],
        ]);
        
        $this->add([
            'name'			=> 'requirements',
            'type'			=> 'textarea',
            'attributes'	=> [
                'placeholder'	=> 'Additional Requirements:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Additional Requirements:',
                'required'	=> false,
            ],
        ]);
        
        $this->add([
            'name'		=> 'terms',
            'type'		=> 'select',
            'options'	=> [
                'label'			=> 'I agree to the Terms of Service',
                'disable_inarray_validator' => true,
                'required'		=> true,
                'empty_option'	=> 'No',
                'value_options'	=> [
                    1 => 'Yes',
                ],
            ],
        ]);
    }
}
