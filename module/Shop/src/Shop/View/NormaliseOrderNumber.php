<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use Zend\Form\View\Helper\AbstractHelper;

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