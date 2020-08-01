<?php

namespace Shop\InputFilter;

use Laminas\Filter\Digits;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;

/**
 * Class Add
 *
 * @package Shop\InputFilter
 */
class CartAddInputFilter extends InputFilter
{
	public function init()
	{
		$this->add([
			'name' => 'qty',
			'required' => true,
			'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
				['name' => Digits::class]
            ]
        ]);
		
		$this->add([
			'name' => 'productId',
			'required' => true,
			'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
				['name' => Digits::class]
            ]
        ]);
		
		$this->add([
			'name' => 'returnTo',
			'required' => true,
			'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ]
        ]);
	}
}
