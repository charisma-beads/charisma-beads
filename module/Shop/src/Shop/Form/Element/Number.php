<?php

namespace Shop\Form\Element;

use Laminas\Form\Element\Number as LaminasFormNumber;

/**
 * Class Number
 *
 * @package Shop\Form\Element
 */
class Number extends LaminasFormNumber
{
    public function getValue()
    {
        $value = parent::getValue();
        $decimals = $this->getOption('decimals');
        return number_format($value, $decimals);
    }
}