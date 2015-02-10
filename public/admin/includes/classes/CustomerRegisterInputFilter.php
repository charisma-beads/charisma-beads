<?php

use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname as HostnameValidator;
use Zend\Db\Adapter\Adapter;
use Zend\Validator\NotEmpty;

class CustomerRegisterInputFilter extends InputFilter
{
	public function __construct($country)
	{
		$UcwordsFilter = new UpperCaseWords();
		
		$this->add(array(
			'name' => 'prefix_id',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array('name' => 'Int')
			),
		));
		
		$this->add(array(
			'name' => 'first_name',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				$UcwordsFilter,
			),
		));
		
		$this->add(array(
			'name' => 'last_name',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				$UcwordsFilter,
			),
		));
		
		$this->add(array(
			'name' => 'address1',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				$UcwordsFilter,
			),
		));
		
		$this->add(array(
			'name' => 'address2',
			'required' => false,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				$UcwordsFilter,
			),
		));
		
		$this->add(array(
			'name' => 'address3',
			'required' => false,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				$UcwordsFilter,
			),
		));
		
		$this->add(array(
			'name' => 'city',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				$UcwordsFilter,
			),
		));
		
		$this->add(array(
			'name' => 'county',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
		));
		
		$this->add(array(
			'name' => 'post_code',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				array('name' => 'StringToUpper'),
			),
			'validators' => array(
				new PostCode(array(
					'country' => $country['code']
				)),
			),
		));
		
		$this->add(array(
			'name' => 'country_id',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array('name' => 'Int')
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
				new PhoneNumber(array(
					'country' => $country['code'],
				)),
			),
		));
		
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
					'domain' 			=> true,
					'useMxCheck' 		=> true,
					'useDeepMxCheck' 	=> true,
				)),
				array('name' => 'Zend\Validator\Db\NoRecordExists', 'options' => array(
					'table'     => 'customers',
					'field'     => 'email',
					'adapter'   => new Adapter(array(
						'driver'         => 'PDO_MYSQL',
						'hostname'       => DB_HOST,
						'database'       => DB_NAME,
						'username'       => DB_USER,
						'password'       => DB_PASSWORD,
					)),
				)),
			),
		));
		
		$this->add(array(
			'name' => 'confirm-email',
			'required' => true,
			'filters' => array(
				array('name' => 'StringTrim'),
				array('name' => 'StripTags'),
				array('name' => 'StringToLower'),
			),
			'validators' => array(
				array('name' => 'Identical', 'options' => array(
					'token' => 'email',
				)),
			),
		));
		
		$this->add(array(
			'name' => 'ad_referrer',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array('name' => 'Int')
			),
		));
		
		$this->add(array(
			'name' => 'newsletter',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
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
				)),
			),
		));
		
		$this->add(array(
			'name' => 'confirm-password',
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