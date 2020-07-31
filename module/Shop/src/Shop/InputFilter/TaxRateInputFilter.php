<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsFloat;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Between;

/**
 * Class Rate
 *
 * @package Shop\InputFilter
 */
class TaxRateInputFilter extends InputFilter
{
	public function init()
	{
		$this->add(array(
			'name'			=> 'taxRate',
			'required'		=> true,
			'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
			'validators'	=> [
				['name' => IsFloat::class],
				['name' => Between::class, 'options' => [
					'min'		=> 0,
					'max'		=> 100,
					'inclusive'	=> true,
                ]],
            ],
		));
	}
}
