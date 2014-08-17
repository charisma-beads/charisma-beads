<?php
namespace Shop\Form\Catalog;

use Zend\Form\Form;

class Search extends Form
{
    public function init()
    {
        $this->add([
        	'name'      => 'productSearch',
            'type'      => 'text',
            'options'   => [
				'required' => false,
			],
			'attributes' => [
				'class'             => 'search-query',	
			    'placeholder'       => 'Type your search...',
			    'autocapitalize'	=> 'off',
			],
        ]);
        
        /**
         * autocapitalize="off"
         * autocorrect="off"
         */
    }
}
