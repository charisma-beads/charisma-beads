<?php
use Zend\Form\Form;

class ChangePasswordForm extends Form
{
	public function init()
	{
		$this->add(array(
			'name' => 'password',
			'type' => 'Password',
			'required' => true,
			'attributes' => array(
				'id'	   => 'password',
				'class'    => 'inputbox'
			),
			'options' => array(
				'label' => 'New Password:'
			),
		));
		
		$this->add(array(
			'name' => 'password-confirm',
			'type' => 'Password',
			'attributes' => array(
				'class'    => 'inputbox'
			),
			'options' => array(
				'label' => 'Comfirm New Password:'
			),
		));
		
		$this->add(array(
				'name' => 'security',
				'type' => 'csrf',
		));
	}
}

?>