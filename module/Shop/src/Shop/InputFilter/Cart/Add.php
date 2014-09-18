<?php
namespace Shop\InputFilter\Cart;

use Zend\InputFilter\InputFilter;

class Add extends InputFilter
{
	public function init()
	{
		$this->add(array(
			'name' => 'qty',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				array('name' => 'Digits')
			)
		));
		
		$this->add(array(
			'name' => 'productId',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				array('name' => 'Digits')
			)
		));
		
		$this->add(array(
			'name' => 'returnTo',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			)
		));
	}
}
