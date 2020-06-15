<?php

namespace Navigation\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;


class MenuInputFilter extends InputFilter
{
	public function init()
	{
		$this->add([
            'name'       => 'menu',
            'required'   => true,
            'filters'    => [
                ['name'    => StripTags::class],
                ['name'    => StringTrim::class],
            ],
            'validators' => [
                [
                    'name'    => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => 2,
                        'max'      => 255,
                    ],
                ],
            ],
		]);
	}
}
