<?php

namespace Shop\InputFilter\Post;

use Zend\InputFilter\InputFilter;

class Zone extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
			'name'       => 'zone',
			'required'   => true,
			'filters'    => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				array('name' => 'Application\Filter\Ucwords'),
			),
			'validators' => array(
				array('name' => 'StringLength', 'options' => array(
					'encoding' => 'UTF-8',
					'min'      => 2,
					'max'      => 255,
				)),
			),
		));
		
		$this->add(array(
			'name'			=> 'taxCodeId',
			'required'		=> true,
			'filters'		=> array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators'	=> array(
				array('name' => 'Int'),
				array('name' => 'GreaterThan', 'options' => array(
					'min' => 0,
				)),
			),
		));
	}
}
