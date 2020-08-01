<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringToUpper;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsFloat;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\StringLength;

/**
 * Class Group
 *
 * @package Shop\InputFilter
 */
class ProductGroupInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'       => 'group',
            'required'   => true,
            'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => StringToUpper::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'	=> [
                ['name' => IsFloat::class]
            ],
        ]);
    }    
}
