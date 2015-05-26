<?php

namespace Shop\Form\Post;

use TwbBundle\Form\View\Helper\TwbBundleForm;
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
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
			],
		]);
	
		$this->add([
			'name'		=> 'taxCodeId',
			'type'		=> 'TaxCodeList',
			'options'	=> [
				'label'			=> 'Tax Code:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
			],
		]);
	}
}
