<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Number;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class Group
 *
 * @package Shop\Form\Product
 */
class ProductGroupForm extends Form
{	
    public function init()
    {
    	$this->add([
    		'name'	=> 'productGroupId',
    		'type'	=> Hidden::class,
    	]);
    	
    	$this->add([
    		'name'			=> 'group',
    		'type'			=> Text::class,
    		'attributes'	=> [
    			'placeholder'		=> 'Group:',
    			'autofocus'			=> true,
    			'autocapitalize'	=> 'on',
    		],
    		'options'		=> [
    			'label'      => 'Group:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
    		],
    	]);
    	
    	$this->add([
    		'name'			=> 'price',
    		'type'			=> Number::class,
    		'attributes'	=> [
    			'placehoder'		=> 'Price:',
    			'autofocus'			=> true,
    		    'min'               => '0.00',
    			'step'			    => '0.01'
    		],
    		'options'		=> [
    			'label'			=> 'Price:',
        		'help-block'	=> 'Do not include the currency sign or commas.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
    		],
    	]);
    }
}
