<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\StringLength;

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
