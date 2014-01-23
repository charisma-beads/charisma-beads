<?php
namespace Shop\InputFilter\Product;

use Zend\InputFilter\InputFilter;

class GroupPrice extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'group',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
                array('name' => 'StringToUpper'),
            ),
            'validators' => array(
                array('name' => 'StringLength', 'options' => array(
                    'encoding' => 'UTF-8',
                    'min'      => 1,
                    'max'      => 5,
                )),
            ),
        ));
        
        $this->add(array(
            'name'			=> 'price',
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
