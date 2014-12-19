<?php
use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname as HostnameValidator;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class CustomerLoginInputFilter extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
			'name' => 'email',
			'required' => true,
			'filters' => array(
				array('name' => 'StringTrim'),
				array('name' => 'StripTags'),
				array('name' => 'StringToLower'),
			),
			'validators' => array(
				array('name' => 'NotEmpty', 'options' => array(
					'messages' => array(
						NotEmpty::IS_EMPTY => "Your email is required and can't be empty",
					),
				)),
				array('name' => 'EmailAddress', 'options' => array(
					'allow' => HostnameValidator::ALLOW_DNS,
					'domain' => true,
				)),
			),
		));
		
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
					'messages' => array(
						StringLength::TOO_SHORT => "Your password is too short. It needs to be 6 characters or more.",
					),
				)),
				array('name' => 'NotEmpty', 'options' => array(
					'messages' => array(
						NotEmpty::IS_EMPTY => "Your password is required and can't be empty",
					),
				)),
			),
		));
	}
}

?>