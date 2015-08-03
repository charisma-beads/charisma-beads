<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Post;

use Zend\InputFilter\InputFilter;

/**
 * Class Cost
 *
 * @package Shop\InputFilter\Post
 */
class Cost extends InputFilter
{
	public function init()
	{
		$this->add([
			'name'			=> 'cost',
			'required'		=> true,
			'filters'		=> [
				['name' => 'StripTags'],
				['name' => 'StringTrim']
            ],
			'validators'	=> [
				['name' => 'Float']
            ],
        ]);
		
		$this->add([
			'name'			=> 'vatInc',
			'required'		=> true,
			'filters'		=> [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
            ],
			'validators'	=> [
				['name' => 'Int'],
				['name' => 'Between', 'options' => [
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
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
            ],
			'validators'	=> [
				['name' => 'Int'],
				['name' => 'GreaterThan', 'options' => [
					'min' => 0,
                ]],
            ],
        ]);
		 
		$this->add([
			'name'			=> 'postZoneId',
			'required'		=> true,
			'filters'		=> [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
            ],
			'validators'	=> [
				['name' => 'Int'],
				['name' => 'GreaterThan', 'options' => [
					'min' => 0,
                ]],
            ],
        ]);
	}
}
