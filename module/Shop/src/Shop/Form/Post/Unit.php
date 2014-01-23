<?php
namespace Shop\Form\Post;

use Zend\Form\Form;

class Unit extends Form
{
    public function init()
    {
        $this->add(array(
            'name'	=> 'postUnitId',
            'type'	=> 'hidden',
        ));
        
        $this->add(array(
            'name'			=> 'postUnit',
            'type'			=> 'number',
            'attributes'	=> array(
                'placeholder'	=> 'Unit:',
                'autofocus'		=> true,
                'step'			=> '0.01'
            ),
            'options'		=> array(
                'label'			=> 'Cost:',
                'required'		=> true,
                'help-inline'	=> 'This should be weight in grams.',
            ),
        ));
    }
}
