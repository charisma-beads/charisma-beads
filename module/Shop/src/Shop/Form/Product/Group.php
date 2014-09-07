<?php
namespace Shop\Form\Product;

use Zend\Form\Form;

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
    		    'required'   => true,
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
    			'required'		=> true,
        		'help-inline'	=> 'Do not include the currency sign or commas.',
    		],
    	]);
    }
}
