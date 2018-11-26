<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use UthandoCommon\Filter\Ucwords;
use Zend\Filter\StringToUpper;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

/**
 * Class Country
 *
 * @package Shop\InputFilter
 */
class CountryInputFilter extends InputFilter
{
	public function init()
	{
		$this->add([
			'name'       => 'country',
			'required'   => true,
			'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
				['name' => Ucwords::class],
			],
			'validators' => [
				array('name' => StringLength::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
		        ['name' => StringToUpper::class],
		    ],
		    'validators' => array(
		        ['name' => StringLength::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
			'validators'	=> [
				['name' => IsInt::class],
				['name' => GreaterThan::class, 'options' => [
					'min' => 0,
				]],
			],
		]);
	}
}
