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
 * Class Zone
 *
 * @package Shop\Form\Post
 */
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
