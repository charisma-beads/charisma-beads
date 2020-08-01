<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsFloat;
use Laminas\InputFilter\InputFilter;

/**
 * Class Level
 *
 * @package Shop\InputFilter
 */
class PostLevelInputFilter extends InputFilter
{
	public function init()
	{
		$this->add([
			'name'			=> 'postLevel',
			'required'		=> true,
			'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
			'validators'	=> [
				['name' => IsFloat::class]
            ],
        ]);
	}
}
