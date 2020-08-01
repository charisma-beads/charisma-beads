<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsFloat;
use Laminas\InputFilter\InputFilter;

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
