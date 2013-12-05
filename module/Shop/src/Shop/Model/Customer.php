<?php
namespace Shop\Model;

use Application\Model\AbstractModel;
use DateTime;

class Customer extends AbstractModel
{
    protected $customerId;
    protected $userId;
    protected $prefixId;
    protected $customerBillingAddressId;
    protected $customerDeliveryAddressId;
    protected $firstname;
    protected $lastname;
}
