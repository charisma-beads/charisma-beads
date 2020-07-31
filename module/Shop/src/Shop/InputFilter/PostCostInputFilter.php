<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsFloat;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Between;
use Laminas\Validator\GreaterThan;

/**
 * Class Cost
 *
 * @package Shop\InputFilter
 */
class PostCostInputFilter extends InputFilter
{
	public function init()
	{
		$this->add([
			'name'			=> 'cost',
			'required'		=> true,
			'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
			'validators'	=> [
				['name' => IsFloat::class]
            ],
        ]);
		
		$this->add([
			'name'			=> 'vatInc',
			'required'		=> true,
			'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
			'validators'	=> [
				['name' => IsInt::class],
				['name' => Between::class, 'options' => [
					'min'		=> 0,
					'max'		=> 1,
					'inclusive'	=> true,
                ]],
            ],
        ]);
		
		$this->add([
			'name'			=> 'postLevelId',
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
