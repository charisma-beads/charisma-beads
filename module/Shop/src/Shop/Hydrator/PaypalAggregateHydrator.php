<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Paypal
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator;

use Zend\Hydrator\Aggregate\AggregateHydrator;

/**
 * Class PaypalAggregate
 *
 * @package Shop\Hydrator
 */
class PaypalAggregateHydrator extends AggregateHydrator
{   
    protected $hydrators = [
        'amount',
        'details',
        'payment',
        'payer',
        'redirectUrls',
        'shippingAddress',
        'transaction'
    ];
    
    public function __construct()
    {
        foreach ($this->hydrators as $hydrator) {
            $this->add(new PaypalHydrator($hydrator));
        }
        
        $this->add(new PaypalItemListHydrator());
    }
}
