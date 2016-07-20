<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Order
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Order;

use TwbBundle\Form\Element\StaticElement;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\DateTime;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class Order
 *
 * @package Shop\Form\Order
 */
class Order extends Form
{
    public function init()
    {
        $this->add([
            'name'  => 'orderId',
            'type'  => Hidden::class,
        ]);

        $this->add([
            'name' => 'customerId',
            'type'  => Hidden::class,
        ]);

        $this->add([
            'name'  => 'orderStatusId',
            'type'  => 'OrderStatusList',
        ]);

        $this->add([
            'name'  => 'orderNumber',
            'type'  => StaticElement::class,
            'options' => [
                'label' => 'Order Number',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
        ]);

        $this->add([
            'name'  => 'total',
            'type'  => Text::class,
            'options' => [
                'label' => 'Total',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
        ]);

        $this->add([
            'name'  => 'shipping',
            'type'  => Text::class,
            'options' => [
                'label' => 'Shipping',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
        ]);

        $this->add([
            'name'  => 'taxTotal',
            'type'  => Text::class,
            'options' => [
                'label' => 'Tax Total',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
        ]);

        $this->add([
            'name'  => 'orderDate',
            'type'  => DateTime::class,
            'options' => [
                'label' => 'Date/Time',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4 date-time-pick',
                'add-on-append' => '<i class="fa fa-calendar"></i>',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
                'format' => 'd/m/Y H:i:s',
            ],
            'attributes' => [
                'class' => 'date-time-pick',
            ],
        ]);

        $this->add([
            'type' => 'ShopOrderLineFieldSet',
            'name' => 'orderLines',
            'options' => [
                'label' => 'Order Lines',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);

        $this->add([
            'type' => 'ShopOrderMetadataFieldSet',
            'name' => 'metadata',
            'options' => [
                'label' => 'Metadata',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);
    }
}
