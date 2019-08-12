<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Catalog
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form;

use Zend\Form\Element\Text;
use Zend\Form\Form;

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