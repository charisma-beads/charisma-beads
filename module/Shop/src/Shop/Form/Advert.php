<?php
namespace Shop\Form;

use Zend\Form\Form;

class Advert extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'advertId',
            'type' => 'hidden',
        ]);
        
        $this->add([
            'name' => 'advert',
            'type' => 'text',
            'options' => [
                'label' => 'Advert Name',
            ],
        ]);
        
        $this->add([
            'name' => 'enabled',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Enabled',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' => false,
            ],
        ]);
    }
}
