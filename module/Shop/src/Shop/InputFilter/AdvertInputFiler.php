<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;

/**
 * Class Advert
 *
 * @package Shop\InputFilter
 */
class AdvertInputFiler extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'advertId',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'   => [
                ['name' => IsInt::class],
            ],
        ]);
        
        $this->add([
            'name' => 'advert',
            'required' => true,
            'filters' => [
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
            'name' => 'enabled',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);
    }
}
