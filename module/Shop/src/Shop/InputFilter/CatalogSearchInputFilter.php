<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Catalog
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripNewlines;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;

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
