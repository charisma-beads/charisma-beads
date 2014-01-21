<?php

namespace Shop\InputFilter\Tax;

use Zend\InputFilter\InputFilter;

class Rate extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
			'name'			=> 'taxRate',
			'required'		=> true,
			'filters'		=> array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators'	=> array(
				array('name' => 'Float'),
				array('name' => 'Between', 'options' => array(
					'min'		=> 0,
					'max'		=> 100,
					'inclusive'	=> true,
				)),
			),
		));
	}
}
