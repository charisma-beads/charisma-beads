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
		
		$this->add(array(
			'name'			=> 'taxRate',
			'type'			=> 'number',
			'attributes'	=> array(
				'placeholder'	=> 'Tax Rate:',
				'autofocus'		=> true,
				'min'			=> '0.00',
				'max'			=> '100.00',
				'step'			=> '0.01',
			),
			'options'		=> array(
				'label' => 'Tax Rate:',
				'help-inline'	=> 'Do not include the % sign.'
			),
		));
	}
}
