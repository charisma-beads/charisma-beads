<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Country
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form;

use Shop\Form\Element\PostZoneList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class Country
 *
 * @package Shop\Form\Country
 */
class CountryForm extends Form
{
	public function init()
	{
		$this->add([
			'name'	=> 'countryId',
			'type'	=> Hidden::class,
		]);
		
		$this->add([
		    'name'      => 'redirectToEdit',
		    'type'      => Hidden::class,
		    'attributes'   => [
		        'value' => true,
		    ],
		]);
		
		$this->add([
        	'name'			=> 'country',
        	'type'			=> Text::class,
        	'attributes'	=> [
        		'placeholder'	=> 'Country:',
        		'autofocus'		=> true,
        	],
        	'options'		=> [
        		'label'		=> 'Country:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
        	],

        ]);
		
		$this->add([
		    'name'		=> 'code',
		    'type'		=> Text::class,
		    'attributes'	=> [
		        'placeholder'	=> 'Country Code:',
        		'autofocus'		=> true,
		    ],
		    'options'		=> [
		        'label'		=> 'Country Code:',
		        'required'	=> true,
		        'help-block' => 'Please use the ISO-3166 alpha 2 country code (two-letters)',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
		    ],
		]);
		
		$this->add([
			'name'		=> 'postZoneId',
			'type'		=> PostZoneList::class,
			'options'	=> [
				'label'     => 'Post Zone:',
				'required'  => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
	}
}
