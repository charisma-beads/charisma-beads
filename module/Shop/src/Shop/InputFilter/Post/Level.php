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
 * Class Level
 *
 * @package Shop\InputFilter\Post
 */
class Level extends InputFilter 
{
	public function init()
	{
		$this->add([
			'name'			=> 'postLevel',
			'required'		=> true,
			'filters'		=> [
				['name' => 'StripTags'],
				['name' => 'StringTrim']
            ],
			'validators'	=> [
				['name' => 'Float']
            ],
        ]);
	}
}
