<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Order;

use Zend\InputFilter\InputFilter;

/**
 * Class Order
 *
 * @package Shop\InputFilter\Order
 */
class Order extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'customerId',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);

        $this->add([
            'name' => 'orderId',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);

        $this->add([
            'name' => 'orderNumber',
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);

        $this->add([
            'name' => 'requirements',
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);
    }
}
