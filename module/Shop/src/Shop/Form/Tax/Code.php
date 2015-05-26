<?php

namespace Shop\Form\Tax;

use TwbBundle\Form\View\Helper\TwbBundleForm;
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
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
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
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
			],
		]);
		
		$this->add([
			'name'		=> 'taxRateId',
			'type'		=> 'TaxRateList',
			'options'	=> [
				'label'			=> 'Tax Rate:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
			],
		]);
	}
}
