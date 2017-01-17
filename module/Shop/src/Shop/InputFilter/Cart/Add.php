<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Cart
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Cart;

use Zend\InputFilter\InputFilter;

/**
 * Class Add
 *
 * @package Shop\InputFilter\Cart
 */
class Add extends InputFilter
{
	public function init()
	{
		$this->add([
			'name' => 'qty',
			'required' => true,
			'filters' => [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
				['name' => 'Digits']
            ]
        ]);
		
		$this->add([
			'name' => 'productId',
			'required' => true,
			'filters' => [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
				['name' => 'Digits']
            ]
        ]);
		
		$this->add([
			'name' => 'returnTo',
			'required' => true,
			'filters' => [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
            ]
        ]);
	}
}
