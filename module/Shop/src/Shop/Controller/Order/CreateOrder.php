<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Controller\Order;

use Shop\Service\Customer\Customer;
use Shop\Service\Order\Order;
use Shop\ShopException;
use UthandoCommon\Service\ServiceTrait;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class CreateOrder
 *
 * @package Shop\Controller\Order
 */
class CreateOrder extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->serviceName = 'ShopOrder';
    }

    public function createAction()
    {
        $customerId = $this->params()->fromRoute('customerId', null);

        if (null === $customerId) {
            throw new ShopException('No customer id was supplied');
        }

        /* @var Customer $service */
        $service = $this->getService('ShopCustomer');

        $customer = $service->getCustomerDetailsByCustomerId($customerId);

        if (null === $customer->getCustomerId()) {
            $this->redirect()->toRoute('admin/shop/customer/edit', [
                'action' => 'add',
            ]);
        }

        return [
            'model' => $customer,
        ];
    }

    public function saveAction()
    {

    }
}