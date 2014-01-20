<?php
namespace Shop\Form\Product;

use Zend\Form\Form;

class Image extends Form
{
    public function __construct()
    {
        parent::__construct('Image Form');
        
        $this->add(array(
        	'name'	=> 'productImageId',
        	'type'	=> 'hidden',
        ));
    }
}
