<?php
namespace Shop\Form\Post;

use TwbBundle\Form\View\Helper\TwbBundleForm;
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
                'label'			=> 'Unit:',
                'help-inline'	=> 'This should be weight in grams.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);
    }
}
