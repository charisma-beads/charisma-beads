<?php
namespace Shop\InputFilter\Product;

use Zend\InputFilter\InputFilter;

class Category extends InputFilter
{
    public function init()
    {
    	$this->add(array(
    		'name'       => 'category',
    		'required'   => true,
    		'filters'    => array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    			array('name' => 'UthandoUcwords'),
    		),
    		'validators' => array(
    			array('name' => 'StringLength', 'options' => array(
    				'encoding' => 'UTF-8',
    				'min'      => 2,
    				'max'      => 255,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'       => 'ident',
    		'required'   => true,
    		'filters'    => array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    			array('name' => 'UthandoSlug')
    		),
    		'validators' => array(
    			array('name' => 'StringLength', 'options' => array(
    				'encoding' => 'UTF-8',
    				'min'      => 2,
    				'max'      => 255,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'enabled',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'Between', 'options' => array(
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	 
    	$this->add(array(
    		'name'			=> 'discontinued',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'Between', 'options' => array(
    				'min'		=> 0,
    				'max'		=> 1,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'productImageId',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'GreaterThan', 'options' => array(
    				'min' 		=> 0,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    	
    	$this->add(array(
    		'name'			=> 'parent',
    		'required'		=> true,
    		'filters'		=> array(
    			array('name' => 'StripTags'),
    			array('name' => 'StringTrim'),
    		),
    		'validators'	=> array(
    			array('name' => 'Int'),
    			array('name' => 'GreaterThan', 'options' => array(
    				'min' 		=> 0,
    				'inclusive'	=> true,
    			)),
    		),
    	));
    }
}
