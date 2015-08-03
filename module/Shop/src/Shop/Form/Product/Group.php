<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Product;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

/**
 * Class Group
 *
 * @package Shop\Form\Product
 */
class Group extends Form
{	
    public function init()
    {
    	$this->add([
    		'name'	=> 'productGroupId',
    		'type'	=> 'hidden',
    	]);
    	
    	$this->add([
    		'name'			=> 'group',
    		'type'			=> 'text',
    		'attributes'	=> [
    			'placeholder'		=> 'Group:',
    			'autofocus'			=> true,
    			'autocapitalize'	=> 'on',
    		],
    		'options'		=> [
    			'label'      => 'Group:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
    		],
    	]);
    	
    	$this->add([
    		'name'			=> 'price',
    		'type'			=> 'number',
    		'attributes'	=> [
    			'placehoder'		=> 'Price:',
    			'autofocus'			=> true,
    		    'min'               => '0.00',
    			'step'			    => '0.01'
    		],
    		'options'		=> [
    			'label'			=> 'Price:',
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
