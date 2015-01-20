<?php

namespace Shop\Form\Post;

use Zend\Form\Form;

class Cost extends Form
{	
	public function init()
	{
		$this->add([
			'name'	=> 'postCostId',
			'type'	=> 'hidden',
		]);
		
		$this->add([
			'name'			=> 'cost',
			'type'			=> 'number',
			'attributes'	=> [
				'placeholder'	=> 'Price:',
				'autofocus'		=> true,
				'step'			=> '0.01'
			],
			'options'		=> [
				'label'			=> 'Cost:',
				'required'		=> true,
				'help-inline'	=> 'Do not include the currency sign or commas.',
			],
		]);
		
		$this->add([
			'name'			=> 'vatInc',
			'type'			=> 'checkbox',
			'options'		=> [
				'label'			=> 'Vat Included:',
				'required' 		=> true,
				'use_hidden_element' => true,
				'checked_value' => '1',
				'unchecked_value' => '0',
			],
		]);
		
		$this->add([
			'name'		=> 'postLevelId',
			'type'		=> 'PostLevelList',
			'options'	=> [
				'label'			=> 'Post Level:',
				'required'		=> true,
			],
		]);
		
		$this->add([
			'name'		=> 'postZoneId',
			'type'		=> 'PostZoneList',
			'options'	=> [
				'label'			=> 'Post Zone:',
				'required'		=> true,
			],
		]);
	}
}
