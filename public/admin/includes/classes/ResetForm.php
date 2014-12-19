<?php
use Zend\Form\Form;

class ResetForm extends Form
{
	public function init()
	{
		$this->add(array(
			'name' => 'email',
			'type'  => 'email',
			'attributes' => array(
				'class'    => 'inputbox'
			),
			'options' => array(
				'label' => 'Email:'
			),
		));
		
		$this->add(array(
			'name' => 'captcha',
			'type' => 'CBCaptcha',
			'options' => array(
				'label'     => 'Please enter the letters and numbers displayed below:',
			),
		));
		
		$this->add(array(
			'name' => 'security',
			'type' => 'csrf',
		));
		
	}
}

?>