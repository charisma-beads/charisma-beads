<?php

namespace Shop\Form\Tax;

use Zend\Form\Form;

class Rate extends Form
{
	public function __construct()
	{
		parent::__construct('Tax Rate Form');
		
		$this->add(array(
			'name'	=> 'taxRateId',
			'type'	=> 'hidden',
		));
	}
}
