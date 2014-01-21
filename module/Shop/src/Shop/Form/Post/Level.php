<?php

namespace Shop\Form\Post;

use Zend\Form\Form;

class Level extends Form
{
	public function init()
	{
		$this->add(array(
			'name'	=> 'postLevelId',
			'type'	=> 'hidden',
		));
		
		$this->add(array(
			'name'			=> 'postLevel',
			'type'			=> 'number',
			'attributes'	=> array(
        		'placeholder'	=> 'Level Price:',
        		'autofocus'		=> true,
        		'step'			=> '0.01'
        	),
        	'options'		=> array(
        		'label'			=> 'Post Level Price:',
        		'required'		=> true,
        		'help-inline'	=> 'Do not include the currency sign or commas.',
        	),
		));
	}
}
