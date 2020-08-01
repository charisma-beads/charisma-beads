<?php

namespace Shop\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Number;
use Laminas\Form\Form;

/**
 * Class Rate
 *
 * @package Shop\Form
 */
class TaxRateForm extends Form
{
	public function init()
	{
		$this->add([
			'name'	=> 'taxRateId',
			'type'	=> Hidden::class,
		]);
		
		$this->add([
			'name'			=> 'taxRate',
			'type'			=> Number::class,
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
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
	}
}
