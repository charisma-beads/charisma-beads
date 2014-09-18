<?php

namespace Shop\InputFilter\Country;

use Zend\InputFilter\InputFilter;

class Country extends InputFilter
{
	public function init()
	{
		$this->add([
			'name'       => 'country',
			'required'   => true,
			'filters'    => [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
				['name' => 'UthandoUcwords'],
			],
			'validators' => [
				array('name' => 'StringLength', 'options' => [
					'encoding' => 'UTF-8',
					'min'      => 2,
					'max'      => 255,
				]),
			],
		]);
		
		$this->add([
		    'name'       => 'code',
		    'required'   => true,
		    'filters'    => [
		        ['name' => 'StripTags'],
		        ['name' => 'StringTrim'],
		        ['name' => 'StringToUpper'],
		    ],
		    'validators' => array(
		        ['name' => 'StringLength', 'options' => [
		            'encoding' => 'UTF-8',
		            'min'      => 2,
		            'max'      => 2,
		        ]],
		    ),
		]);
		
		$this->add([
			'name'			=> 'postZoneId',
			'required'		=> true,
			'filters'		=> [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
			],
			'validators'	=> [
				['name' => 'Int'],
				['name' => 'GreaterThan', 'options' => [
					'min' => 0,
				]],
			],
		]);
	}
}
