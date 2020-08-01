<?php

namespace Shop\View;

use Laminas\Form\View\Helper\AbstractHelper;

/**
 * Class NormaliseOrderNumber
 *
 * @package Shop\View
 */
class NormaliseOrderNumber extends AbstractHelper
{
    public function __invoke($orderNumber)
    {
        $orderNumber = substr($orderNumber, 8, -1);
        return ltrim($orderNumber, '0');
    }
}