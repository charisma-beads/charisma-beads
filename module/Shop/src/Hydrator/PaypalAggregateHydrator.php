<?php

namespace Shop\Hydrator;

use Laminas\Hydrator\Aggregate\AggregateHydrator;

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
