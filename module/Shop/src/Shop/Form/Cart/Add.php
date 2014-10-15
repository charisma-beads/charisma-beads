<?php
namespace Shop\Form\Cart;

use Zend\Form\Form;

class Add extends Form
{
	public function init()
	{
		$this->add([
			'name' => 'qty',
			'type' => 'number',
			'options' => [
				'label' => 'Quantity:',
				'required' => true,
			],
			'attributes' => [
				'min'  => '0',
				'step' => '1',
				'value' => 1,		
			],
		]);

        $this->add([
           'name' => 'options',
           'type' => 'select',
            'options' => [
                'label' => 'Product Options',
            ]
        ]);
		
		$this->add([
			'name' => 'buy-item',
			'type' => 'submit',
			'options' => [
				'label' => 'Add to Cart',
				
			],
			'attributes' => [
				'class' => 'btn',
			],
		]);
		
		$this->add([
			'name' => 'productId',
			'type' => 'hidden',
		]);
	
		$this->add([
			'name' => 'returnTo',
			'type' => 'hidden',
		]);
	}
}
