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
use Zend\I18n\Validator\IsFloat;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;
use Zend\Validator\GreaterThan;

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
