<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\StringLength;

/**
 * Class Zone
 *
 * @package Shop\InputFilter
 */
class PostZoneInputFilter extends InputFilter
{
	public function init()
	{
		$this->add([
			'name'       => 'zone',
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
			'name'			=> 'taxCodeId',
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
