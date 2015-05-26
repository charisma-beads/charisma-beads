<?php

namespace Shop\Form\Tax;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

class Rate extends Form
{
	public function init()
	{
		$this->add([
			'name'	=> 'taxRateId',
			'type'	=> 'hidden',
		]);
		
		$this->add([
			'name'			=> 'taxRate',
			'type'			=> 'number',
			'attributes'	=> [
				'placeholder'	=> 'Tax Rate:',
				'autofocus'		=> true,
				'min'			=> '0.00',
				'max'			=> '100.00',
				'step'			=> '0.01',
			],
			'options'		=> [
				'label' => 'Tax Rate:',
				'help-inline'	=> 'Do not include the % sign.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
			],
		]);
	}
}
