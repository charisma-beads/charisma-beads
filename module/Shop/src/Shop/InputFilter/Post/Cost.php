<?php

namespace Shop\InputFilter\Post;

use Zend\InputFilter\InputFilter;

class Cost extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
			'name'			=> 'cost',
			'required'		=> true,
			'filters'		=> array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim')
			),
			'validators'	=> array(
				array('name' => 'Float')
			),
		));
		
		$this->add(array(
			'name'			=> 'vatInc',
			'required'		=> true,
			'filters'		=> array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators'	=> array(
				array('name' => 'Int'),
				array('name' => 'Between', 'options' => array(
					'min'		=> 0,
					'max'		=> 1,
					'inclusive'	=> true,
				)),
			),
		));
		
		$this->add(array(
			'name'			=> 'postLevelId',
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
		 
		$this->add(array(
			'name'			=> 'postZoneId',
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
