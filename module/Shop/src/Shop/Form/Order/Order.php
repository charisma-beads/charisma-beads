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

use Shop\Model\Order\Order as OrderModel;
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
            'name'  => 'orderNumber',
            'type'  => StaticElement::class,
            'options' => [
                'label' => 'Order Number',
                'column-size' => 'md-10',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);

        $this->add([
            'name'  => 'orderStatusId',
            'type'  => 'OrderStatusList',
            'options' => [
                'label' => 'Order Status',
                'column-size' => 'md-10',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);

        /*$this->add([
            'name'		=> 'payment_option',
            'type'		=> 'PayOptionsList',
            'options'	=> [
                'required'		=> true,
                'disable_inarray_validator' => true,
                'column-size' => 'md-10 col-md-offset-2',
                'inline' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
        ]);*/

        $this->add([
            'name'			=> 'collect_instore',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Collect Instore',
                'required' 		=> false,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-10 col-md-offset-2',
            ],
        ]);

        $this->add([
            'name'			=> 'requirements',
            'type'			=> 'Textarea',
            'options'		=> [
                'label'		=> 'Additional Requirements',
                'required'	=> false,
            ],
            'attributes' => [
                'placeholder'	=> 'Additional Requirements',
                'autofocus'		=> true,
                'class' => 'form-control',
                'rows' => 10,
            ]
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
                'column-size' => 'md-10 date-time-pick',
                'add-on-append' => '<i class="fa fa-calendar"></i>',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
                'format' => 'd/m/Y H:i:s',
            ],
            'attributes' => [
                'class' => 'date-time-pick',
                'step' => 'any',
            ],
        ]);

        $orderDate = $this->get('orderDate')->getValue();

        if (!$orderDate) {
            $dateTime = new \DateTime();
            $this->get('orderDate')->setValue($dateTime->format('d/m/Y H:i:s'));
        }
    }

    public function configureFormValues(OrderModel $order)
    {
        if ($order->getMetadata()->getShippingMethod() == 'Collect At Store') {
            $this->get('collect_instore')->setValue(1);
        }

        $this->get('requirements')->setValue($order->getMetadata()->getRequirements());
    }
}
