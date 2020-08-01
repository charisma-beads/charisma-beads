<?php

namespace Shop\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\StripNewlines;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;

/**
 * Class Search
 *
 * @package Shop\InputFilter
 */
class CatalogSearchInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
        	'name' => 'productSearch',
            'required'   => false,
            'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => StripNewlines::class],
            ],
        ]);
    }
}
