<?php
namespace Shop\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
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
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
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
                'column-size' => 'md-4 col-md-offset-2',
            ],
        ]);
    }
}
