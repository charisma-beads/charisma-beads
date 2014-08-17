<?php

namespace Shop\Form\Tax;

use Zend\Form\Form;

class Code extends Form
{	
	public function init()
	{
		$this->add([
			'name'	=> 'taxCodeId',
			'type'	=> 'hidden',
		]);
		
		$this->add([
			'name'			=> 'taxCode',
			'type'			=> 'text',
			'attributes'	=> [
				'placeholder'		=> 'Tax Code:',
				'autofocus'			=> true,
				'autocapitalize'	=> 'on',
			],
			'options'		=> [
				'label' => 'Tax Code:',
			],
		]);
		
		$this->add([
			'name'			=> 'description',
			'type'			=> 'text',
			'attributes'	=> [
				'placeholder'		=> 'Description:',
				'autofocus'			=> true,
				'autocapitalise'	=> 'on',
			],
			'options'		=> [
				'label'	=> 'Description:',
			],
		]);
		
		$this->add([
			'name'		=> 'taxRateId',
			'type'		=> 'TaxRateList',
			'options'	=> [
				'label'			=> 'Tax Rate:',
				'required'		=> true,
			],
		]);
	}
}
