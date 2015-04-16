<?php

namespace Shop\InputFilter\Tax;

use Zend\InputFilter\InputFilter;

class Code extends InputFilter
{
	public function init()
	{
		$this->add([
			'name'       => 'taxCode',
			'required'   => true,
			'filters'    => [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
				['name' => 'StringToUpper'],
			],
			'validators' => [
				['name' => 'StringLength', 'options' => [
					'encoding' => 'UTF-8',
					'min'      => 1,
					'max'      => 3,
				]],
			],
		]);
		
		$this->add([
			'name'       => 'description',
			'required'   => true,
			'filters'    => [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
			],
			'validators' => [
				['name' => 'StringLength', 'options' => [
					'encoding' => 'UTF-8',
					'min'      => 2,
					'max'      => 255,
				]],
			],
		]);
		
		$this->add([
			'name'			=> 'taxRateId',
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
