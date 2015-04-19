<?php

namespace Shop\Form\Country;

use Zend\Form\Form;

class Country extends Form
{
	public function init()
	{
		$this->add([
			'name'	=> 'countryId',
			'type'	=> 'hidden',
		]);
		
		$this->add([
        	'name'			=> 'country',
        	'type'			=> 'text',
        	'attributes'	=> [
        		'placeholder'	=> 'Country:',
        		'autofocus'		=> true,
        	],
        	'options'		=> [
        		'label'		=> 'Country:',
        		'required'	=> true,
        	],
        ]);
		
		$this->add([
		    'name'		=> 'code',
		    'type'		=> 'text',
		    'options'	=> [
		        'placeholder'	=> 'Country Code:',
        		'autofocus'		=> true,
		    ],
		    'options'		=> [
		        'label'		=> 'Country Code:',
		        'required'	=> true,
		        'help-block' => 'Please use the ISO-3166 alpha 2 country code (two-letters)',
		    ],
		]);
		
		$this->add([
			'name'		=> 'postZoneId',
			'type'		=> 'PostZoneList',
			'options'	=> [
				'label'     => 'Post Zone:',
				'required'  => true,
			],
		]);
	}
}
