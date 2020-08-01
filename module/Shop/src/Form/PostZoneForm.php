<?php

namespace Shop\Form;

use Shop\Form\Element\TaxCodeList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Form;

/**
 * Class Zone
 *
 * @package Shop\Form
 */
class PostZoneForm extends Form
{	
	public function init()
	{
		$this->add([
			'name'	=> 'postZoneId',
			'type'	=> Hidden::class,
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
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
	
		$this->add([
			'name'		=> 'taxCodeId',
			'type'		=> TaxCodeList::class,
			'options'	=> [
				'label'			=> 'Tax Code:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
	}
}
