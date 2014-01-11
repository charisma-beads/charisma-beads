<?php
namespace Shop\Form\Product;

use Zend\Form\Form;

class Category extends Form
{
    public function __construct()
    {
    	parent::__construct('Category From');
    	
    	$this->add(array(
    		'name'			=> 'category',
    		'type'			=> 'text',
    		'attributes'	=> array(
    			'placeholder'		=> 'Category:',
    			'autofocus'			=> true,
    			'autocapitalize'	=> 'on',
    		),
    		'options'		=> array(
    			'label'	=> 'Category:',
    		)
    	));
    	
    	$this->add(array(
    		'name'			=> 'ident',
    		'type'			=> 'text',
    		'attributes'	=> array(
    			'placehoder'		=> 'Ident:',
    			'autofocus'			=> true,
    			'autocapitalize'	=> 'off'
    		),
    		'options'		=> array(
    			'label'			=> 'Ident:',
    			'help-inline'	=> 'If you leave this blank the the category name will be used for the ident.'
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'enabled',
    		'type'			=> 'checkbox',
    		'options'		=> array(
    			'label'			=> 'Enabled:',
    			'use_hidden_element' => true,
    			'checked_value' => '1',
    			'unchecked_value' => '0',
    			'required' 		=> true,
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'discontinued',
    		'type'			=> 'checkbox',
    		'options'		=> array(
    			'label'			=> 'Discontinued:',
    			'required' 		=> true,
    			'use_hidden_element' => true,
    			'checked_value' => '1',
    			'unchecked_value' => '0',
    		),
    	));
    }
}
