<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsFloat;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;

/**
 * Class Rate
 *
 * @package Shop\InputFilter
 */
class TaxRateInputFilter extends InputFilter
{
	public function init()
	{
		$this->add(array(
			'name'			=> 'taxRate',
			'required'		=> true,
			'filters'		=> [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
			'validators'	=> [
				['name' => IsFloat::class],
				['name' => Between::class, 'options' => [
					'min'		=> 0,
					'max'		=> 100,
					'inclusive'	=> true,
                ]],
            ],
		));
	}
}
