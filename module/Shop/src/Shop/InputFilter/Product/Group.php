<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Product;

use Zend\InputFilter\InputFilter;

/**
 * Class Group
 *
 * @package Shop\InputFilter\Product
 */
class Group extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'       => 'group',
            'required'   => true,
            'filters'    => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'StringToUpper'],
            ],
            'validators' => [
                ['name' => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 1,
                    'max'      => 5,
                ]],
            ],
        ]);
        
        $this->add([
            'name'			=> 'price',
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
