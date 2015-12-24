<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Tax;

use Zend\InputFilter\InputFilter;

/**
 * Class Code
 *
 * @package Shop\InputFilter\Tax
 */
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
