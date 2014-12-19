<?php

use Zend\Form\Form;

class CustomerLoginForm extends Form
{	
	public function init()
	{	
		$this->add(array(
			'name' => 'email',
			'type'  => 'email',
			'attributes' => array(
				'class'    => 'inputbox',
				'required' => true,
			),
			'options' => array(
				'label' => 'Email:'
			),
		));
		
		$this->add(array(
			'name' => 'password',
			'type' => 'Password',
			'required' => true,
			'attributes' => array(
				'id'			=> 'password',
				'class'    => 'inputbox',
				'required' => true,
			),
			'options' => array(
				'label' => 'Password:'
			),
		));
		
		/*$this->add(array(
			'name' => 'captcha',
			'type' => 'CBCaptcha',
			'options' => array(
				'label'     => 'Please enter the letters and numbers displayed below:',
			),
		));*/

        $this->add(array(
            'name' => 'security',
        	'type' => 'csrf',
        ));
		
		$this->add(array(
			'name' => 'referer_link',
			'type' => 'hidden',
		));
		
	}
	
}

?>