<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Tax;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

/**
 * Class Rate
 *
 * @package Shop\Form\Tax
 */
class Rate extends Form
{
	public function init()
	{
		$this->add([
			'name'	=> 'taxRateId',
			'type'	=> 'hidden',
		]);
		
		$this->add([
			'name'			=> 'taxRate',
			'type'			=> 'number',
			'attributes'	=> [
				'placeholder'	=> 'Tax Rate:',
				'autofocus'		=> true,
				'min'			=> '0.00',
				'max'			=> '100.00',
				'step'			=> '0.01',
			],
			'options'		=> [
				'label' => 'Tax Rate:',
				'help-inline'	=> 'Do not include the % sign.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
	}
}
