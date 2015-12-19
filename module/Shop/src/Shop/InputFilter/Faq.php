<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Class Faq
 *
 * @package Shop\InputFilter
 */
class Faq extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'       => 'faqId',
            'required'   => false,
            'filters'    => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);

        $this->add([
            'name'       => 'question',
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
            'name'       => 'answer',
            'required'   => true,
            'filters'    => [
                ['name' => 'StringTrim'],
            ],
        ]);

        $this->add([
            'name'			=> 'parent',
            'required'		=> false,
            'filters'		=> [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators'	=> [
                ['name' => 'Int'],
                ['name' => 'GreaterThan', 'options' => [
                    'min' 		=> 0,
                    'inclusive'	=> true,
                ]],
            ],
        ]);
    }
}
