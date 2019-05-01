<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Form\OrderForm;
use Shop\Hydrator\OrderHydrator;
use Shop\InputFilter\OrderInputFilter;
use Shop\Mapper\OrderMapper;
use Shop\Model\CustomerModel;
use Shop\Model\OrderLineInterface;
use Shop\Model\OrderMetaDataModel;
use Shop\Model\OrderModel;
use Shop\Model\ProductModel;
use Shop\Model\ProductOptionModel as ProductOption;
use Shop\Model\ProductOptionModel;
use Shop\Model\VoucherCodeModel as VoucherCode;
use Shop\Options\CartOptions;
use Shop\Options\OrderOptions;
use Shop\Validator\Voucher;
use Zend\Json\Json;
use Zend\Mail\Protocol\Exception\RuntimeException;
use Zend\Math\BigInteger\BigInteger;
use Zend\View\Model\ViewModel;

/**
 * Class Order
 *
 * @package Shop\Service
 * @method OrderModel populate($model, $children)
 * @method OrderMapper getMapper($mapperClass = null, array $options = [])
 * @method OrderModel getOrderModel()
 */
class OrderService extends AbstractOrderService
{
    protected $form         = OrderForm::class;
    protected $hydrator     = OrderHydrator::class;
    protected $inputFilter  = OrderInputFilter::class;
    protected $mapper       = OrderMapper::class;
    protected $model        = OrderModel::class;

    /**
     * @var string
     */
    protected $lineService = OrderLineService::class;

    /**
     * @var array
     */
    protected $tags = [
        'order', 'customer', 'order-lines',
        'order-status',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'customer'      => [
            'refCol'        => 'customerId',
            'service'       => CustomerService::class,
            'getMethod'     => 'getCustomerDetailsByCustomerId',
        ],
        'orderStatus'   => [
            'refCol'        => 'orderStatusId',
            'service'       => OrderStatusService::class,
        ],
        OrderLineService::class    => [
            'refCol'        => 'orderId',
            'service'       => OrderLineService::class,
            'getMethod'     => 'getOrderLinesByOrderId',
            'setMethod'     => 'setEntities',
        ],
    ];

    /**
     * @var array
     */
    protected $orderStatusMap = [
        'pay_check'         => 'Cheque Payment pending',
        'pay_phone'         => 'Waiting for Payment',
        'pay_credit_card'   => 'Card Payment Pending',
        'pay_paypal'        => 'Paypal Payment Pending',
        'pay_pending'       => 'Pending',
    ];

    /**
     * @return \Shop\Options\CartOptions
     */
    public function getCartOptions()
    {
        return $this->getServiceLocator()->get(CartOptions::class);
    }

    /**
     * @param $id
     * @param null $col
     * @return OrderModel
     */
    public function getById($id, $col = null)
    {
        $order = parent::getById($id, $col);

        if ($order) {
            $this->populate($order, true);
        }

        return $order;
    }

    /**
     * @param $id
     * @return OrderModel
     * @throws \UthandoCommon\Model\CollectionException
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function getOrder($id)
    {
        $order = $this->getById($id);

        $order->setSortOrder($this->getShopOptions()->getProductsOrderCol());

        $order->setAutoIncrementQuantity(
            $this->getCartOptions()->isAutoIncrementCart()
        );

        $order->setEntities([]);

        $this->loadItems($order);

        $this->setOrderModel($order);

        return $this->getOrderModel();
    }

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getCustomerOrdersByCustomerId($id)
    {
        $id = (int) $id;
        /* @var $mapper \Shop\Mapper\OrderMapper */
        $mapper = $this->getMapper();

        $orders = $mapper->getOrdersByCustomerId($id);
        foreach ($orders as $order) {
            $this->populate($order, true);
        }

        return $orders;
    }

    /**
     * @param int $orderId
     * @return int
     * @throws \UthandoCommon\Model\CollectionException
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function processOrderFromCart($orderId)
    {
        $this->getOrder($orderId);

        /* @var $cart CartService */
        $cart = $this->getService(CartService::class);

        $code = $cart->getContainer()->offsetGet('voucher');

        /* @var Voucher $voucherValidator */
        $voucherValidator = $this->getServiceLocator()
            ->get('ValidatorManager')
            ->get(Voucher::class);

        $voucherValidator->setOrderModel($cart->getOrderModel())
            ->setCustomer($this->getOrderModel()->getCustomer());

        if ($code && $voucherValidator->isValid($code)) {
            /* @var $voucherService VoucherCodeService */
            $voucherService = $this->getService(VoucherCodeService::class);

            $voucher = $voucherService->getVoucherByCode($code);

        } else {
            $cart->getContainer()->offsetSet('voucher', null);
            $cart->getOrderModel()
                ->setDiscount(0);
            $voucher = new VoucherCode();
        }

        if ('Collect at Open Day' == $this->getOrderModel()->getMetadata()->getShippingMethod()) {
            $cart->setShippingCost(null, true);
        } else {
            $cart->setShippingCost(
                $this->getOrderModel()
                    ->getCustomer()
                    ->getDeliveryAddress()
                    ->getCountryId()
            );
        }

        $shipping   = $cart->getShippingCost();
        $taxTotal   = $cart->getTaxTotal();
        $discount   = $cart->getCart()->getDiscount();
        $cartTotal  = $cart->getTotal();

        $this->getOrderModel()->setTotal($cartTotal)
            ->setTaxTotal($taxTotal)
            ->setShipping($shipping)
            ->setShippingTax($cart->getShippingTax())
            ->setDiscount($discount)
            ->getMetadata()->setVoucher($voucher);

        /* @var $orderLineService \Shop\Service\OrderLineService */
        $orderLineService = $this->getService(OrderLineService::class);
        $orderLineService->processLines($cart->getCart(), $orderId);

        $this->loadItems($this->getOrderModel());

        //$this->recalculateTotals();
        
        $result = $this->save($this->getOrderModel());

        $this->sendEmail($orderId);

        $order = $this->getOrderModel();
        $argv = compact('voucher', 'order');
        $argv = $this->prepareEventArguments($argv);
        $this->getEventManager()->trigger('voucher.use', $this, $argv);
        
        return $orderId;
    }

    /**
     * @param CustomerModel $customer
     * @param $postData
     * @return int
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function create(CustomerModel $customer, $postData)
    {
        $collectInStore = ($postData['collect_instore']) ? true : false;

        /* @var $orderStatusService \Shop\Service\OrderStatusService */
        $orderStatusService = $this->getService(OrderStatusService::class);

        /* @var $orderStatus \Shop\Model\OrderStatusModel */
        $orderStatus = $orderStatusService->getStatusByName($this->orderStatusMap[$postData['payment_option']]);

        $metadata = new OrderMetaDataModel();

        $paymentOption = ucwords(str_replace(
            '_',
            ' ',
            str_replace('pay_', '', $postData['payment_option'])
        ));

        $shopOptions = $this->getShopOptions();

        $metadata->setPaymentMethod($paymentOption)
            ->setTaxInvoice($shopOptions->isVatState())
            ->setRequirements($postData['requirements'])
            ->setCustomerName($customer->getFullName(), $customer->getPrefix()->getPrefix())
            ->setBillingAddress($customer->getBillingAddress())
            ->setDeliveryAddress($customer->getDeliveryAddress())
            ->setEmail($customer->getEmail());

        if (true === $collectInStore) {
            $metadata->setShippingMethod('Collect at Open Day');
        }

        $data = [
            'customerId'    => $customer->getCustomerId(),
            'orderStatusId' => $orderStatus->getOrderStatusId(),
            'total'         => 0,
            'shipping'      => 0,
            'taxTotal'      => 0,
            'shippingTax'   => 0,
            'orderDate'     => New \DateTime(),
            'metadata'      => $metadata,
            'customer'      => $customer,
            'orderStatus'   => $orderStatus,
        ];

        $order = $this->getMapper()->getModel($data);
        $orderId = $this->save($order);
        $this->generateOrderNumber($orderId);

        return $orderId;
    }

    /**
     * Adds items contained with the order collection
     *
     * @param ProductModel $product
     * @param array $post
     * @return OrderLineInterface|bool
     * @throws \UthandoCommon\Model\CollectionException
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function addItem(ProductModel $product, $post)
    {
        $qty = $post['qty'];

        if ($qty <= 0 || $product->inStock() === false || $product->isDiscontinued() === true || $product->isEnabled() === false) {
            return false;
        }

        $productClone = clone $product;

        $productId = $productClone->getProductId();
        $optionId = (isset($post['ProductOptionList'])) ? (int) substr(strrchr($post['ProductOptionList'], "-"), 1) : null;

        $productOption = ($optionId) ? $product->getProductOption($optionId) : null;

        if ($productOption instanceof ProductOption) {
            $productClone->setPostUnitId($productOption->getPostUnitId())
                ->setPostUnit($productOption->getPostUnit())
                ->setPrice($productOption->getPrice(false))
                ->setDiscountPercent($productOption->getDiscountPercent());
            $productId = $productId . '-' . $optionId;
        }

        $model = $this->getOrderModel();
        $lineModel = $model->getEntityClass();

        /** @var $line OrderLineInterface */
        $line = ($model->offsetExists($productId)) ? $model->offsetGet($productId) : new $lineModel();

        if ($model->isAutoIncrementQuantity()) {
            $qty = $qty + $line->getQuantity();
        }

        $argv = compact('product', 'qty', 'line');
        $argv = $this->prepareEventArguments($argv);
        $this->getEventManager()->trigger('stock.check', $this, $argv);

        $qty = $argv['qty'];

        if (0 == $qty) {
            $this->removeItem($line->getId());
            return false;
        }

        $line->setPrice($productClone->getPrice())
            ->setQuantity($qty)
            ->setTax($productClone->getTaxCode()->getTaxRate()->getTaxRate())
            ->setMetadata($this->getProductMetaData($productClone, $optionId))
            ->setParentId($model->getId());

        $model->offsetSet($productId, $line);

        $this->persist($line);

        $this->getEventManager()->trigger('stock.save', $this, $argv);

        return $line;
    }

    /**
     * Updates order items.
     *
     * @param array $items
     * @throws \UthandoCommon\Model\CollectionException
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function updateItem(array $items)
    {
        $orderModel = $this->getOrderModel();

        foreach ($items as $lineItemId => $qty) {

            $line = $orderModel->getLineById($lineItemId);

            if (!$line || $qty < 0) continue;

            if ($qty == 0) {
                $this->removeItem($lineItemId);
            } else {

                /* @var $productService ProductService */
                $productService = $this->getService(ProductService::class);
                $product = $productService->getById($line->getMetadata()->getProductId());

                $argv = compact('product', 'qty', 'line');
                $argv = $this->prepareEventArguments($argv);

                $this->getEventManager()->trigger('stock.check', $this, $argv);

                $qty = $argv['qty'];

                $line->setQuantity($qty);

                $offsetKey = $line->getMetadata()->getProductId();

                // check for option
                if ($line->getMetadata()->getOption() instanceof ProductOptionModel) {
                    $offsetKey = join('-', [
                        $offsetKey,
                        $line->getMetadata()->getOption()->getProductOptionId()
                    ]);
                }

                $orderModel->offsetSet($offsetKey, $line);

                $this->getEventManager()->trigger('stock.save', $this, $argv);
            }
        }

        $this->persist();
    }

    public function removeItem($id)
    {
        $item = $this->getRelatedService($this->lineService)->getById($id);
        $argv = compact('item');
        $argv = $this->prepareEventArguments($argv);

        $this->getEventManager()->trigger('stock.restore', $this, $argv);

        parent::removeItem($id);
    }

    /**
     * Recalculate totals of order
     */
    public function calculateTotals()
    {
        $sub = 0;
        $tax = 0;
        $this->getOrderModel()->setTaxTotal(0);

        /* @var $lineItem \Shop\Model\OrderLineModel */
        foreach($this->getOrderModel() as $lineItem) {
            $sub = $sub + (($lineItem->getPrice()) * $lineItem->getQuantity());
            $this->getOrderModel()->setTaxTotal(
                $this->getOrderModel()->getTaxTotal() + ($lineItem->getTax() * $lineItem->getQuantity())
            );
        }

        $this->getOrderModel()->setSubTotal($sub);

        $shipping = $this->getShippingService();

        if ($this->getOrderModel()->getMetadata()->getShippingMethod() == 'Collect at Open Day') {
            $shipping->setCountryId(0);
        } else {
            $shipping->setCountryId($this->getOrderModel()->getMetadata()->getDeliveryAddress()->getCountryId());
        }

        $cost = $shipping->calculateShipping($this->getOrderModel());

        $this->getOrderModel()->setShipping($cost);
        $this->setShippingTax($shipping->getShippingTax());

        $this->getOrderModel()->setTotal(
            $this->getOrderModel()->getSubTotal() + $this->getOrderModel()->getShipping()
        );
        $this->getOrderModel()->setTaxTotal(
            $this->getOrderModel()->getTaxTotal() + $this->getOrderModel()->getShippingTax()
        );

        $this->getEventManager()->trigger('order.voucher.check', $this);

        $this->save($this->getOrderModel());
    }

    /**
     * @param OrderLineInterface|null $line
     * @return void
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function persist(OrderLineInterface $line = null)
    {
        $order = $this->getOrderModel();
        $order->setOrderDate();

        if (null === $line->getOrderId()) {
            $line->setCartId($order->getOrderId());
        }

        $priceTax = $this->calculateTax($line);
        $line->setPrice($priceTax['price']);
        $line->setTax($priceTax['tax']);

        $this->getRelatedService($this->lineService)->save($line);
    }

    /**
     * Generate simple order number with check digit.
     * This allows for 9999999 orders
     * Format <Date><OrderId padded to 7 digits><Check Digit>
     *
     * @param OrderModel|int $orderModelOrId
     * @return OrderModel
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function generateOrderNumber($orderModelOrId)
    {
        if (!$orderModelOrId instanceof OrderModel) {
            $orderModelOrId = (int) $orderModelOrId;
            $orderModelOrId = $this->getById($orderModelOrId);
        }

        $part1 = $orderModelOrId->getOrderDate()->format('Ymd');
        $part2 = sprintf('%07d', $orderModelOrId->getOrderId());

        $num = join('', [
            $part1, $part2
        ]);

        $bigInt = BigInteger::factory('bcmath');
        $checkSum = $bigInt->mod($num, 11);
        $checkSum = $bigInt->mod($checkSum, 10);
        $orderModelOrId->setOrderNumber($num . $checkSum);

        $this->save($orderModelOrId);
        
        return $orderModelOrId;
    }

    /**
     * @param int $orderNumber
     * @param int $orderStatus
     * @return int
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function updateOrderStatus($orderNumber, $orderStatus)
    {
        /* @var $options \Shop\Options\OrderOptions */
        $options = $this->getService(OrderOptions::class);

        $orderNumber = (string) $orderNumber;
        $orderStatus = (int) $orderStatus;
        /* @var $mapper \Shop\Mapper\OrderMapper */
        $mapper = $this->getMapper();
        $order = $mapper->getOrderByOrderNumber($orderNumber);
        
        $order->setOrderStatusId($orderStatus);
        $result = $this->save($order);

        if ($result && $options->isEmailCustomerOnStatusChange()) {
            $this->populate($order, true);

            if (!$order->getCustomer()->getEmail()) {
                return $result;
            }

            $shopOptions = $this->getShopOptions();

            $subject = 'Order Status From %s Order No. %s';

            $emailView = new ViewModel([
                'order' => $order,
            ]);

            $emailView->setTemplate('shop/email/status-change');

            try {
                $this->getEventManager()->trigger('mail.send', $this, [
                    'recipient'        => [
                        'name'      => $order->getCustomer()->getFullName(),
                        'address'   => $order->getCustomer()->getEmail(),
                    ],
                    'layout'           => 'shop/email/order',
                    'layout_params'    => ['order' => $order],
                    'body'             => $emailView,
                    'subject'          => sprintf($subject, $shopOptions->getMerchantName(), $order->getOrderNumber()),
                    'transport'        => $options->getOrderEmail(),
                ]);
            } catch (RuntimeException $e) {
                return $result;
            }
        }

        return $result;
    }

    /**
     * @param int $id
     * @param int $userId
     * @return mixed
     */
    public function getCustomerOrderByUserId($id, $userId)
    {
        $id = (int) $id;
        $userId = (int) $userId;
        /* @var $mapper \Shop\Mapper\OrderMapper */
        $mapper = $this->getMapper();
        $order = $mapper->getOrderByUserId($id, $userId);
        
        if ($order) {
            $this->populate($order, true);
        }

        return $order;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getCustomerOrdersByUserId($userId)
    {
        $userId = (int) $userId;
        /* @var $mapper \Shop\Mapper\OrderMapper */
        $mapper = $this->getMapper();
        $orders = $mapper->getOrdersByUserId($userId);
        
        foreach ($orders as $order) {
            $this->populate($order, true);
        }
        
        return $orders;
    }

    /**
     * @return mixed
     */
    public function getCurrentOrders()
    {
        /* @var $mapper \Shop\Mapper\OrderMapper */
        $mapper = $this->getMapper();
        $orders = $mapper->getCurrentOrders();

        foreach ($orders as $order) {
            $this->populate($order, ['customer', 'orderStatus']);
        }

        return $orders;
    }

    /**
     * @param null|string $start
     * @param null|string $end
     * @param string $monthFormat
     * @return string
     * @throws \Exception
     */
    public function getMonthlyTotals($start = null, $end = null, $monthFormat = 'm')
    {
        $startDate = new \DateTime($start);
        $start = $startDate->format('Y-m-d');

        if ($end) {
            $endDate = new \DateTime($end);
            $end = $endDate->format('Y-m-d');
        }

        $resultSet = $this->getMapper()
            ->getMonthlyTotals($start, $end);

        $totalsArray = [];
        $year = null;

        $c = -1;

        foreach ($resultSet as $row) {

            // if we start with a new year.
            if ($year != $row->year) {
                $c++;
                $totalsArray[$c]['label'] = $row->year;

                // if row doesn't start at beginning of year the pad missing months
                if ($row->month != '01') {

                    $monthDigit = (int) ltrim($row->month, '0');

                    for ($i=1; $i < $monthDigit; $i++) {
                        $dateObj = \DateTime::createFromFormat('!m', $i);
                        $month = $dateObj->format($monthFormat);
                        $totalsArray[$c]['data'][] = [$month, 0.00];
                        $totalsArray[$c]['numOrders'][$month] = 0;
                    }
                }
            }

            $dateObj = \DateTime::createFromFormat('!m', $row->month);
            $month = $dateObj->format($monthFormat);

            $totalsArray[$c]['data'][] = [$month, $row->total];
            $totalsArray[$c]['numOrders'][$month] = $row->numOrders;
            $year = $row->year;
        }

        return Json::encode($totalsArray);
    }

    /**
     * send order via email
     *
     * @param $orderId
     * @return \Exception|null|RuntimeException
     */
    public function sendEmail($orderId)
    {
        $order = $this->getById($orderId);
        $order = $this->populate($order, true);
        $emailResult = null;
        
        $email = $order->getCustomer()->getEmail();
        /* @var $options \Shop\Options\OrderOptions */
        $options = $this->getService(OrderOptions::class);
        $shopOptions = $this->getShopOptions();

        $emailView = new ViewModel([
            'order' => $order,
        ]);
        
        $emailView->setTemplate('shop/order/table-view');

        $subject = 'Order Confirmation From %s Order No. %s';

        if ($email) {
            try {
                $this->getEventManager()->trigger('mail.send', $this, [
                    'recipient' => [
                        'name' => $order->getCustomer()->getFullName(),
                        'address' => $email,
                    ],
                    'layout' => 'shop/email/order',
                    'layout_params' => ['order' => $order],
                    'body' => $emailView,
                    'subject' => sprintf($subject, $shopOptions->getMerchantName(), $order->getOrderNumber()),
                    'transport' => $options->getOrderEmail(),
                ]);
            } catch (RuntimeException $e) {
                $emailResult = $e;
            }
        }
        
        if ($options->getSendOrderToAdmin()) {
            $sender = [];

            if ($email) {
                $sender = [
                    'sender'        => [
                        'name'      => $order->getCustomer()->getFullName(),
                        'address'   => $email,
                    ],
                ];
            }
            $this->getEventManager()->trigger('mail.send', $this, array_merge([
                'layout'           => 'shop/email/order',
                'layout_params'    => ['order' => $order],
                'body'             => $emailView,
                'subject'          => sprintf($subject, $order->getCustomer()->getFullName(), $order->getOrderNumber()),
                'transport'        => $options->getOrderEmail(),
            ], $sender));
        }

        return $emailResult;
    }

    /**
     * @param int $id
     * @param int $userId
     * @return bool
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function cancelOrder($id, $userId)
    {
    	$id = (int) $id;
    	$userId = (int) $userId;

        /* @var $mapper \Shop\Mapper\OrderMapper */
        $mapper = $this->getMapper();
    	
    	/* @var $order OrderModel */
    	$order = $mapper->getOrderByUserId($id, $userId);
        //$this->populate($order, true);
    
    	if ($order) {
            /* @var $orderStatusService OrderStatusService */
            $orderStatusService = $this->getService(OrderStatusService::class);
    		$orderStatus = $orderStatusService->getStatusByName('Cancelled');
    		$order->setOrderStatusId($orderStatus->getOrderStatusId());

    		$result = $this->save($order);
    		
    		if ($result) {
    		    return true;
    		}
    	}
    
    	return false;
    }
}
