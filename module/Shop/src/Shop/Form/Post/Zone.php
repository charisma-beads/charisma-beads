<?php

namespace Shop\Form\Post;

use Zend\Form\Form;

class Zone extends Form
{	
	public function init()
	{
		$this->add([
			'name'	=> 'postZoneId',
			'type'	=> 'hidden',
		]);
		
		$this->add([
			'name'			=> 'zone',
			'type'			=> 'text',
			'attributes'	=> [
				'placeholder'	=> 'Post Zone:',
				'autofocus'		=> true,
			],
			'options'		=> [
				'label'		=> 'Post Zone:',
				'required'	=> true,
			],
		]);
	
		$this->add([
			'name'		=> 'taxCodeId',
			'type'		=> 'TaxCodeList',
			'options'	=> [
				'label'			=> 'Tax Code:',
				'required'		=> true,
			],
		]);
	}
}
