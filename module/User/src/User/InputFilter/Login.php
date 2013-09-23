<?php
namespace User\InputFilter;

use Zend\InputFilter\InputFilter;

class Login extends InputFilter
{
    public function __construct()
    {
    	$this->add(array(
			'name'       => 'email',
			'required'   => true,
			'filters'    => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
    	));
    
    	$this->add(array(
			'name'       => 'passwd',
			'required'   => true,
			'filters'    => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
    	));
    }
}
