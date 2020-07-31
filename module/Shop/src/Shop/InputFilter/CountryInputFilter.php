<?php

namespace Shop\InputFilter;

use Common\Filter\Ucwords;
use Laminas\Filter\StringToUpper;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\StringLength;

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
