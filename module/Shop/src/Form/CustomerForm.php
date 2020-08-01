<?php

namespace Shop\Form;

use Shop\Form\Element\CustomerAddressList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Form;

/**
 * Class Customer
 *
 * @package Shop\Form\Customer
 */
class CustomerForm extends Form
{
    use CustomerTrait;

    public function init()
    {
        $this->add([
            'name' => 'customerId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'userId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'redirectToEdit',
            'type' => Hidden::class,
            'attributes' => [
                'value' => true,
            ],
        ]);

        $this->addElements();

        $this->add([
            'name' => 'billingAddressId',
            'type' => CustomerAddressList::class,
            'options' => [
                'label' => 'Billing Address:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'deliveryAddressId',
            'type' => CustomerAddressList::class,
            'options' => [
                'label' => 'Delivery Address:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],

            ],
        ]);
    }
}
