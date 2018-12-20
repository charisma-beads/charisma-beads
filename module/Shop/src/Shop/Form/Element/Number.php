<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Element;

use Zend\Form\Element\Number as ZendFormNumber;

/**
 * Class Number
 *
 * @package Shop\Form\Element
 */
class Number extends ZendFormNumber
{
    public function getValue()
    {
        $value = parent::getValue();
        $decimals = $this->getOption('decimals');
        return number_format($value, $decimals);
    }
}