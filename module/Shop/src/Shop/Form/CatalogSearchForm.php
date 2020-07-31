<?php

namespace Shop\Form;

use Laminas\Form\Element\Text;
use Laminas\Form\Form;

/**
 * Class Search
 *
 * @package Shop\Form
 */
class CatalogSearchForm extends Form
{
    public function init()
    {
        $this->add([
        	'name'      => 'productSearch',
            'type'      => Text::class,
            'options'   => [
				'required' => false,
			],
			'attributes' => [
				'class'             => 'form-control search-query',
			    'placeholder'       => 'Type your search...',
			    'autocapitalize'	=> 'off',
			],
        ]);
    }
}
