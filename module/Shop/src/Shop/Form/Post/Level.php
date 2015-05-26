<?php

namespace Shop\Form\Post;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

/**
 * Class Level
 *
 * @package Shop\Form\Post
 */
class Level extends Form
{
	public function init()
	{
		$this->add([
			'name'	=> 'postLevelId',
			'type'	=> 'hidden',
		]);
		
		$this->add([
			'name'			=> 'postLevel',
			'type'			=> 'number',
			'attributes'	=> [
        		'placeholder'	=> 'Level Price:',
        		'autofocus'		=> true,
        		'step'			=> '0.01'
        	],
        	'options'		=> [
        		'label'			=> 'Post Level Price:',
        		'help-inline'	=> 'Do not include the currency sign or commas.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
        	],
		]);
	}
}
