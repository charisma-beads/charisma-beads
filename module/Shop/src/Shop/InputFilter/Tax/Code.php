<?php

namespace Shop\InputFilter\Tax;

use Zend\InputFilter\InputFilter;

class Code extends InputFilter
{
	public function init()
	{
		$this->add(array(
			'name'       => 'taxCode',
			'required'   => true,
			'filters'    => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				array('name' => 'StringToUpper'),
			),
			'validators' => array(
				array('name' => 'StringLength', 'options' => array(
					'encoding' => 'UTF-8',
					'min'      => 1,
					'max'      => 3,
				)),
			),
		));
		
		$this->add(array(
			'name'       => 'name',
			'required'   => true,
			'filters'    => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
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
			'name'			=> 'taxRateId',
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
