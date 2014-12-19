<?php

use Zend\Form\Form;

class ContactForm extends Form 
{
	public function init()
	{
		$this->add(array(
			'name' => 'email',
			'type' => 'email',
			'attributes' => array(
				'placeholder' => 'Email:',
				'required' => true,
				'size' => 30,
			),
			'options' => array(
				'label' => 'Email:',
			),
		));
		
		$this->add(array(
			'name' => 'name',
			'type' => 'text',
			'attributes' => array(
				'placeholder' => 'Your Name:',
				'required' => true,
				'size' => 30,
			),
			'options' => array(
				'label' => 'Your Name:',
			),
		));

        $this->add(array(
            'name' => 'phone',
            'type' => 'text',
            'attributes' => array(
                'placeholder' => 'Phone Number:',
                'required' => true,
                'size' => 30,
            ),
            'options' => array(
                'label' => 'Phone Number:',
            ),
        ));
		
		$this->add(array(
			'name' => 'department',
			'type' => 'select',
			'options' => array(
				'label' => 'Department:',
				'required' => true,
                'empty_option' => 'Please choose a department',
                'value_options' => array(
                	'default' => 'General Enquiries (Shop and bead related inquiries)',
					'webmaster' => 'Webmaster (Technical problems and broken links)',
				),
			),
			'attributes' => array(
				'required' => true,
			),
		));
		
		$this->add(array(
			'name'  => 'subject',
			'type' => 'text',
			'options' => array(
				'label' => 'Subject:',
			),
			'attributes' => array(
				'placeholder' => 'Subject:',
				'size' => 74,
				'required' => true,
			),
		));
		
		$this->add(array(
			'name'  => 'message',
			'type'  => 'textarea',
			'options' => array(
				'label' => 'Your message:',
			),
			'attributes' => array(
				'placeholder' => 'Your Message:',
				'rows' => 15,
				'cols' => 66,
				'required' => true
			),
		));
		
		$this->add(array(
			'name' => 'captcha',
			'type' => 'CBCaptcha',
			'options' => array(
				'label' => 'Please verify you are human.'
			),
		));
		
		$this->add(array(
			'name' => 'security',
			'type' => 'csrf',
		));
	}
}

?>