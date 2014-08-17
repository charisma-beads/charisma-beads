<?php

namespace Shop\InputFilter;

use Zend\InputFilter\InputFilter;

class Country extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
			'name'       => 'country',
			'required'   => true,
			'filters'    => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				array('name' => 'UthandoCommon\Filter\Ucwords'),
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
		    'name'       => 'code',
		    'required'   => true,
		    'filters'    => array(
		        array('name' => 'StripTags'),
		        array('name' => 'StringTrim'),
		        array('name' => 'StringToUpper'),
		    ),
		    'validators' => array(
		        array('name' => 'StringLength', 'options' => array(
		            'encoding' => 'UTF-8',
		            'min'      => 2,
		            'max'      => 2,
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
