<?php

namespace Shop\Form\Country;

use TwbBundle\Form\View\Helper\TwbBundleForm;
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
		    'name'      => 'redirectToEdit',
		    'type'      => 'hidden',
		    'attributes'   => [
		        'value' => true,
		    ],
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
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
        	],

        ]);
		
		$this->add([
		    'name'		=> 'code',
		    'type'		=> 'text',
		    'attributes'	=> [
		        'placeholder'	=> 'Country Code:',
        		'autofocus'		=> true,
		    ],
		    'options'		=> [
		        'label'		=> 'Country Code:',
		        'required'	=> true,
		        'help-block' => 'Please use the ISO-3166 alpha 2 country code (two-letters)',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
		    ],
		]);
		
		$this->add([
			'name'		=> 'postZoneId',
			'type'		=> 'PostZoneList',
			'options'	=> [
				'label'     => 'Post Zone:',
				'required'  => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
			],
		]);
	}
}
