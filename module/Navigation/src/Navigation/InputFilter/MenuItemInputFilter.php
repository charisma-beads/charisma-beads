<?php

namespace Navigation\InputFilter;

use Common\Filter\Ucwords;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Uri\Http;
use Zend\Validator\StringLength;
use Zend\Validator\Uri;


class MenuItemInputFilter extends InputFilter
{
	public function init()
	{
		$this->add([
            'name'       => 'label',
            'required'   => true,
            'filters'    => [
                ['name'    => StripTags::class],
                ['name'    => StringTrim::class],
                ['name'    => Ucwords::class],
            ],
            'validators' => [
                ['name'    => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]],
            ],
        ]);
		
		$this->add([
            'name'       => 'params',
            'required'   => false,
            'filters'    => [
                ['name'    => StripTags::class],
                ['name'    => StringTrim::class],
            ],
        ]);
		
		$this->add([
            'name'       => 'route',
            'required'   => false,
            'filters'    => [
                ['name'    => StripTags::class],
                ['name'    => StringTrim::class],
            ],
            'validators' => [
                ['name'    => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 0,
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name'       => 'uri',
            'required'   => false,
            'filters'    => [
                ['name'    => StripTags::class],
                ['name'    => StringTrim::class],
            ],
            'validators' => [
                ['name'    => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 0,
                    'max'      => 255,
                ]],
                ['name' => Uri::class, 'options' => [
                    'uriHandler'    => Http::class,
                    'allowRelative' => false,
                ]],
            ],
        ]);
		
		$this->add([
            'name'       => 'resource',
            'required'   => false,
            'allow_empty' => true,
            'filters'    => [
                ['name'    => StripTags::class],
                ['name'    => StringTrim::class],
            ],
            'validators' => [
                ['name'    => StringLength::class,'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]],
            ],
        ]);
	}
}
