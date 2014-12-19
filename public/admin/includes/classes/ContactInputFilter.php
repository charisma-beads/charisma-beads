<?php
use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname as HostnameValidator;
use Zend\Validator\NotEmpty;

class ContactInputFilter extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
			'name' => 'name',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim')
			),
			'validators' => array(
				array('name' => 'NotEmpty', array(
					'messages' => array(
						NotEmpty::IS_EMPTY => "Your name is required and can't be empty",
					),
				)),
			),
		));
		
		$this->add(array(
			'name' => 'email',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim')
			),
			'validators' => array(
				array('name' => 'EmailAddress', 'options' => array(
					'allow' 			=> HostnameValidator::ALLOW_DNS,
					'domain' 			=> true,
					'useMxCheck' 		=> true,
					'useDeepMxCheck' 	=> true,
				)),
				array('name' => 'NotEmpty', array(
					'messages' => array(
						NotEmpty::IS_EMPTY => "Your email is required and can't be empty",
					),
				)),
			),
		));

        $this->add(array(
            'name' => 'phone',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
                array('name' => 'Digits'),
            ),
            'validators' => array(
                array('name' => 'Digits'),
            ),
        ));
		
		$this->add(array(
			'name'       => 'subject',
			'required'   => true,
			'filters'    => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim')
			),
			'validators' => array(
				array('name' => 'NotEmpty', array(
					'messages' => array(
						NotEmpty::IS_EMPTY => "The subject is required and can't be empty",
					),
				)),
			),
		));
		
		$this->add(array(
			'name' => 'department',
			'required' => true,
			'filters'    => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim')
			),
		));
		
		$this->add(array(
			'name' => 'message',
			'required' => true,
			'filters'    => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim')
			),
			'validators' => array(
				array('name' => 'NotEmpty', array(
					'messages' => array(
						NotEmpty::IS_EMPTY => "A message is required and can't be empty",
					),
				)),
			),
		));
	}
}

?>