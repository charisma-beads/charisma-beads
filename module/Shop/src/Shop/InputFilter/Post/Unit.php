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
 * Class Unit
 *
 * @package Shop\InputFilter\Post
 */
class Unit extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'			=> 'postUnit',
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
