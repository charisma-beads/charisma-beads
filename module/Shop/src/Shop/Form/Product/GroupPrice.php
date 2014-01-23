<?php
namespace Shop\Form\Product;

use Zend\Form\Form;

class GroupPrice extends Form
{	
    public function init()
    {
    	$this->add(array(
    		'name'	=> 'productGroupId',
    		'type'	=> 'hidden',
    	));
    	
    	$this->add(array(
    		'name'			=> 'group',
    		'type'			=> 'text',
    		'attributes'	=> array(
    			'placeholder'		=> 'Group:',
    			'autofocus'			=> true,
    			'autocapitalize'	=> 'on',
    		),
    		'options'		=> array(
    			'label'      => 'Group:',
    		    'required'   => true,
    		)
    	));
    	
    	$this->add(array(
    		'name'			=> 'price',
    		'type'			=> 'number',
    		'attributes'	=> array(
    			'placehoder'		=> 'Price:',
    			'autofocus'			=> true,
    		    'min'               => '0.00',
    			'step'			    => '0.01'
    		),
    		'options'		=> array(
    			'label'			=> 'Price:',
    			'required'		=> true,
        		'help-inline'	=> 'Do not include the currency sign or commas.',
    		),
    	));
    }
}
