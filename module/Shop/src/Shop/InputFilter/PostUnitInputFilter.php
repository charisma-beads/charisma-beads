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
use Zend\InputFilter\InputFilter;

/**
 * Class Unit
 *
 * @package Shop\InputFilter
 */
class PostUnitInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'			=> 'postUnit',
            'required'		=> true,
            'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'	=> [
                ['name' => IsFloat::class]
            ],
        ]);
    }
}
