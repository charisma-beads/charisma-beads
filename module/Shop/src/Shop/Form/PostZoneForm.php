<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form;

use Shop\Form\Element\TaxCodeList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Hidden;
use Zend\Form\Form;

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
