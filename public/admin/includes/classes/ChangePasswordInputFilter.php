<?php
use Zend\InputFilter\InputFilter;

class ChangePasswordInputFilter extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
			'name' => 'password',
			'required' => true,
			'filters' => array(
				array('name' => 'StringTrim'),
				array('name' => 'StripTags'),
			),
			'validators' => array(
				array('name' => 'StringLength', 'options' => array(
					'min'       => 6,
					'encoding'  => 'UTF-8',
				)),
			),
		));
		
		$this->add(array(
			'name' => 'password-confirm',
			'required' => true,
			'filters' => array(
				array('name' => 'StringTrim'),
				array('name' => 'StripTags'),
			),
			'validators' => array(
				array('name' => 'StringLength', 'options' => array(
					'min'       => 6,
					'encoding'  => 'UTF-8',
				)),
				array('name' => 'Identical', 'options' => array(
					'token' => 'password',
				)),
			),
		));
	}
}

?>