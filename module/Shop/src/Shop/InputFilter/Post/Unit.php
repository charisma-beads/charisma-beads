<?php
namespace Shop\InputFilter\Post;

use Zend\InputFilter\InputFilter;

class Unit extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'			=> 'postUnit',
            'required'		=> true,
            'filters'		=> array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim')
            ),
            'validators'	=> array(
                array('name' => 'Float')
            ),
        ));
    }
}
