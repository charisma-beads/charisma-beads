<?php

namespace Shop\InputFilter\Post;

use Zend\InputFilter\InputFilter;

class Level extends InputFilter 
{
	public function __construct()
	{
		$this->add(array(
			'name'			=> 'postLevel',
			'required'		=> true,
			'filters'		=> array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim')
			),
			'validators'	=> array(
				array('name' => 'Float')
			),
		));
	}
}
