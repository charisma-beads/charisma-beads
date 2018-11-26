<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

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
