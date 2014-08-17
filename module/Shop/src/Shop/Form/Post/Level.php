<?php

namespace Shop\Form\Post;

use Zend\Form\Form;

class Level extends Form
{
	public function init()
	{
		$this->add([
			'name'	=> 'postLevelId',
			'type'	=> 'hidden',
		]);
		
		$this->add([
			'name'			=> 'postLevel',
			'type'			=> 'number',
			'attributes'	=> [
        		'placeholder'	=> 'Level Price:',
        		'autofocus'		=> true,
        		'step'			=> '0.01'
        	],
        	'options'		=> [
        		'label'			=> 'Post Level Price:',
        		'required'		=> true,
        		'help-inline'	=> 'Do not include the currency sign or commas.',
        	],
		]);
	}
}
