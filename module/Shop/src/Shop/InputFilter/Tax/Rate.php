<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Tax;

use Zend\InputFilter\InputFilter;

/**
 * Class Rate
 *
 * @package Shop\InputFilter\Tax
 */
class Rate extends InputFilter
{
	public function init()
	{
		$this->add(array(
			'name'			=> 'taxRate',
			'required'		=> true,
			'filters'		=> [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
            ],
			'validators'	=> [
				['name' => 'Float'],
				['name' => 'Between', 'options' => [
					'min'		=> 0,
					'max'		=> 100,
					'inclusive'	=> true,
                ]],
            ],
		));
	}
}
