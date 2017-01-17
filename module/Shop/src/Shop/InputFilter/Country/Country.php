<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Country;

use Zend\InputFilter\InputFilter;

/**
 * Class Country
 *
 * @package Shop\InputFilter\Country
 */
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
