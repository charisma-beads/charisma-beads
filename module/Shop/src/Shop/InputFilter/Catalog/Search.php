<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Catalog
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Catalog;

use Zend\InputFilter\InputFilter;

/**
 * Class Search
 *
 * @package Shop\InputFilter\Catalog
 */
class Search extends InputFilter
{
    public function init()
    {
        $this->add([
        	'name' => 'productSearch',
            'required'   => false,
            'filters'    => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'StripNewlines'],
            ],
        ]);
    }
}
