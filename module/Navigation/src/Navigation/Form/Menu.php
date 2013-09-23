<?php

namespace Navigation\Form;

use Zend\Form\Form;

class Menu extends Form
{
	public function __construct()
	{
		parent::__construct('Menu');
		
		$this->add(array(
			'name' => 'menuId',
			'type' => 'hidden',
		));
		
		$this->add(array(
			'name' => 'menu',
			'type' => 'text',
			'options' => array(
				'label' => 'Menu Title:',
				'required' => true,
			),
			'attributes' => array(
				'placeholder' => 'Menu Title:',
			),
		));
	}
}
