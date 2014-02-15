<?php
namespace Shop\Form\Catalog;

use Zend\Form\Form;

class Search extends Form
{
    public function __construct()
    {
        parent::__construct();
        
        $this->add(array(
        	'name'      => 'productSearch',
            'type'      => 'text',
            'options'   => array(
				'required' => false,
			),
			'attributes' => array(
				'class'             => 'search-query',	
			    'placeholder'       => 'Type your search...',
			    'autocapitalize'	=> 'off',
			)
        ));
        
        /**
         * autocapitalize="off"
         * autocorrect="off"
         */
    }
}
