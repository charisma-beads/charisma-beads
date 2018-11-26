<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form;

use Shop\Form\Element\TaxRateList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class Code
 *
 * @package Shop\Form
 */
class TaxCodeForm extends Form
{	
	public function init()
	{
		$this->add([
			'name'	=> 'taxCodeId',
			'type'	=> Hidden::class,
		]);
		
		$this->add([
			'name'			=> 'taxCode',
			'type'			=> Text::class,
			'attributes'	=> [
				'placeholder'		=> 'Tax Code:',
				'autofocus'			=> true,
				'autocapitalize'	=> 'on',
			],
			'options'		=> [
				'label' => 'Tax Code:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
		
		$this->add([
			'name'			=> 'description',
			'type'			=> Text::class,
			'attributes'	=> [
				'placeholder'		=> 'Description:',
				'autofocus'			=> true,
				'autocapitalise'	=> 'on',
			],
			'options'		=> [
				'label'	=> 'Description:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
		
		$this->add([
			'name'		=> 'taxRateId',
			'type'		=> TaxRateList::class,
			'options'	=> [
				'label'			=> 'Tax Rate:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
	}
}
