<?php
use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname as HostnameValidator;
use Zend\Db\Adapter\Adapter;

class ResetInputFilter extends InputFilter
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
				array('name' => 'EmailAddress', 'options' => array(
					'allow' 			=> HostnameValidator::ALLOW_DNS,
					'domain' 			=> true,
					'useMxCheck' 		=> true,
					'useDeepMxCheck' 	=> true,
				)),
				array('name' => 'Zend\Validator\Db\RecordExists', 'options' => array(
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
	}
}

?>