<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringToUpper;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\StringLength;

/**
 * Class Code
 *
 * @package Shop\InputFilter
 */
class TaxCodeInputFilter extends InputFilter
{
	public function init()
	{
		$this->add([
			'name'       => 'taxCode',
			'required'   => true,
			'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
				['name' => StringToUpper::class],
			],
			'validators' => [
				['name' => StringLength::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
			],
			'validators' => [
				['name' => StringLength::class, 'options' => [
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
