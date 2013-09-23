<?php
namespace Navigation\InputFilter;

use Zend\InputFilter\InputFilter;

class Menu extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
            'name'       => 'menu',
            'required'   => true,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 2,
                        'max'      => 255,
                    ),
                ),
            ),
		));
	}
}
