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

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

/**
 * Class Faq
 *
 * @package Shop\InputFilter
 */
class FaqInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'       => 'faqId',
            'required'   => false,
            'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name'       => 'question',
            'required'   => true,
            'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
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
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name'			=> 'parent',
            'required'		=> false,
            'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'	=> [
                ['name' => IsInt::class],
                ['name' => GreaterThan::class, 'options' => [
                    'min' 		=> 0,
                    'inclusive'	=> true,
                ]],
            ],
        ]);
    }
}
