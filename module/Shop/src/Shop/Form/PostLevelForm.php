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

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Number;
use Zend\Form\Form;

/**
 * Class Level
 *
 * @package Shop\Form
 */
class PostLevelForm extends Form
{
	public function init()
	{
		$this->add([
			'name'	=> 'postLevelId',
			'type'	=> Hidden::class,
		]);
		
		$this->add([
			'name'			=> 'postLevel',
			'type'			=> Number::class,
			'attributes'	=> [
        		'placeholder'	=> 'Level Price:',
        		'autofocus'		=> true,
        		'step'			=> '0.01'
        	],
        	'options'		=> [
        		'label'			=> 'Post Level Price:',
        		'help-inline'	=> 'Do not include the currency sign or commas.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
        	],
		]);
	}
}
