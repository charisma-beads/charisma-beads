<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Order;

use Zend\Form\Form;

/**
 * Class Confirm
 *
 * @package Shop\Form\Order
 */
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
                'add_prefix' => true,
            ],
            
        ]);
        
        $this->add([
            'name'			=> 'collect_instore',
            'type'			=> 'checkbox',
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
