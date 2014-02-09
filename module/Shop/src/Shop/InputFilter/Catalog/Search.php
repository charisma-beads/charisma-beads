<?php
namespace Shop\InputFilter\Catalog;

use Zend\InputFilter\InputFilter;

class Search extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
        	'name' => 'searchString',
            'required'   => false,
            'filters'    => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
                array('name' => 'StripNewlines'),
            ),
        ));
    }
}
