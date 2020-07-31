<?php

namespace Shop\Form;

use Shop\Form\Element\TaxRateList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;

/**
 * Class Code
 *
 * @package Shop\Form
 */
class TaxCodeForm extends Form
{	
	public function init()
	{
		$this->add([
			'name'	=> 'taxCodeId',
			'type'	=> Hidden::class,
		]);
		
		$this->add([
			'name'			=> 'taxCode',
			'type'			=> Text::class,
			'attributes'	=> [
				'placeholder'		=> 'Tax Code:',
				'autofocus'			=> true,
				'autocapitalize'	=> 'on',
			],
			'options'		=> [
				'label' => 'Tax Code:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
		
		$this->add([
			'name'			=> 'description',
			'type'			=> Text::class,
			'attributes'	=> [
				'placeholder'		=> 'Description:',
				'autofocus'			=> true,
				'autocapitalise'	=> 'on',
			],
			'options'		=> [
				'label'	=> 'Description:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
		
		$this->add([
			'name'		=> 'taxRateId',
			'type'		=> TaxRateList::class,
			'options'	=> [
				'label'			=> 'Tax Rate:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
	}
}
