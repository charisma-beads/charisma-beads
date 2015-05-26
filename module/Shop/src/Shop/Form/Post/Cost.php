<?php

namespace Shop\Form\Post;

use TwbBundle\Form\View\Helper\TwbBundleForm;
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
				'help-inline'	=> 'Do not include the currency sign or commas.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
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
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4 col-md-offset-2',
			],
		]);
		
		$this->add([
			'name'		=> 'postLevelId',
			'type'		=> 'PostLevelList',
			'options'	=> [
				'label'			=> 'Post Level:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
			],
		]);
		
		$this->add([
			'name'		=> 'postZoneId',
			'type'		=> 'PostZoneList',
			'options'	=> [
				'label'			=> 'Post Zone:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
			],
		]);
	}
}
