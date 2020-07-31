<?php

namespace Shop\Form;

use Shop\Form\Element\PostLevelList;
use Shop\Form\Element\PostZoneList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Number;
use Laminas\Form\Form;

/**
 * Class Cost
 *
 * @package Shop\Form\Post
 */
class PostCostForm extends Form
{	
	public function init()
	{
		$this->add([
			'name'	=> 'postCostId',
			'type'	=> Hidden::class,
		]);
		
		$this->add([
			'name'			=> 'cost',
			'type'			=> Number::class,
			'attributes'	=> [
				'placeholder'	=> 'Price:',
				'autofocus'		=> true,
				'step'			=> '0.01'
			],
			'options'		=> [
				'label'			=> 'Cost:',
				'help-inline'	=> 'Do not include the currency sign or commas.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
		
		$this->add([
			'name'			=> 'vatInc',
			'type'			=> Checkbox::class,
			'options'		=> [
				'label'			=> 'Vat Included',
				'required' 		=> true,
				'use_hidden_element' => true,
				'checked_value' => '1',
				'unchecked_value' => '0',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
			],
		]);
		
		$this->add([
			'name'		=> 'postLevelId',
			'type'		=> PostLevelList::class,
			'options'	=> [
				'label'			=> 'Post Level:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
		
		$this->add([
			'name'		=> 'postZoneId',
			'type'		=> PostZoneList::class,
			'options'	=> [
				'label'			=> 'Post Zone:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
	}
}
