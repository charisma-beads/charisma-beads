<?php
namespace Shop\Hydrator\Paypal;

use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

class PaypalAggregate extends AggregateHydrator
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
    
    public function __contruct()
    {
        foreach ($this->hydrators as $hydrator) {
            $this->add(new PaypalHydrator($hydrator));
        }
        
        $this->add(new ItemList());
    }
}
