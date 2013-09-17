<?php
namespace Shop\Form\Cart;

use Zend\Form\Form;

class Add extends Form
{
	public function __construct()
	{
		parent::__construct();
		
		$this->add(array(
			'name' => 'qty',
			'type' => 'number',
			'options' => array(
				'label' => 'Quantity:',
				'required' => true,
			),
			'attributes' => array(
				'class' => 'input-mini',
				'min'  => '0',
				'step' => '1',
				'value' => 1		
			)
		));
		
		$this->add(array(
			'name' => 'buy-item',
			'type' => 'submit',
			'options' => array(
				'label' => 'Add to Cart',
				
			),
			'attributes' => array(
				'class' => 'btn',
			),
		));
		
		$this->add(array(
			'name' => 'productId',
			'type' => 'hidden'
		));
	
		$this->add(array(
			'name' => 'returnTo',
			'type' => 'hidden'
		));
	}
}
