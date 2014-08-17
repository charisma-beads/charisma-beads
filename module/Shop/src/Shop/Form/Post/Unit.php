<?php
namespace Shop\Form\Post;

use Zend\Form\Form;

class Unit extends Form
{
    public function init()
    {
        $this->add([
            'name'	=> 'postUnitId',
            'type'	=> 'hidden',
        ]);
        
        $this->add([
            'name'			=> 'postUnit',
            'type'			=> 'number',
            'attributes'	=> [
                'placeholder'	=> 'Unit:',
                'autofocus'		=> true,
                'step'			=> '0.01'
            ],
            'options'		=> [
                'label'			=> 'Cost:',
                'required'		=> true,
                'help-inline'	=> 'This should be weight in grams.',
            ],
        ]);
    }
}
