<?php
namespace Shop\InputFilter\Catalog;

use Zend\InputFilter\InputFilter;

class Search extends InputFilter
{
    public function init()
    {
        $this->add(array(
        	'name' => 'productSearch',
            'required'   => false,
            'filters'    => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
                array('name' => 'StripNewlines'),
            ),
        ));
    }
}
