<?php

namespace Shop\Form;


use Shop\Form\Element\PayOptionsList;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;

/**
 * Class Confirm
 *
 * @package Shop\Form
 */
class OrderConfirmForm extends Form
{
    public function init()
    {
        $this->add([
            'name'		=> 'payment_option',
            'type'		=> PayOptionsList::class,
            'options'	=> [
                'label'			=> 'Choose Payment Options',
                'required'		=> true,
                'disable_inarray_validator' => true,
                'label_options' => [
                    'disable_html_escape' => true,
                ],
                'label_attributes' => [
                    'class' => 'radio',
                ],
                'add_prefix' => true,
            ],
            
        ]);
        
        $this->add([
            'name'			=> 'collect_instore',
            'type'			=> Checkbox::class,
            'options'		=> [
                'label'			=> 'Collect at Open Day',
                'required' 		=> false,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
            ],
        ]);
        
        $this->add([
            'name'			=> 'requirements',
            'type'			=> Textarea::class,
            'attributes'	=> [
                'placeholder'	=> 'Additional Requirements',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Additional Requirements',
                'required'	=> false,
            ],
        ]);
        
        $this->add([
            'name'		=> 'terms',
            'type'		=> Select::class,
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
