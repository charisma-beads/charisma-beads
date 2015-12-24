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
 * Class Zone
 *
 * @package Shop\InputFilter\Post
 */
class Zone extends InputFilter
{
	public function init()
	{
		$this->add([
			'name'       => 'zone',
			'required'   => true,
			'filters'    => [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
            ],
			'validators' => [
				['name' => 'StringLength', 'options' => [
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
