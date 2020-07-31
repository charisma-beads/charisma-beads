<?php

namespace Shop\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;

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
