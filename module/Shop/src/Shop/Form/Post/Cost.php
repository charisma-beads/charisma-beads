<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Post;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

/**
 * Class Cost
 *
 * @package Shop\Form\Post
 */
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
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
		
		$this->add([
			'name'			=> 'vatInc',
			'type'			=> 'checkbox',
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
			'type'		=> 'PostLevelList',
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
			'type'		=> 'PostZoneList',
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
