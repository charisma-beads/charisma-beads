<?php

namespace Shop\Form;

use Shop\Form\Element\PostZoneList;
use Shop\Form\Element\ProductCategoryList;
use Shop\Model\VoucherCodeModel;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Date;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;

/**
 * Class Voucher
 *
 * @package Shop\Form
 */
class VoucherCodeForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'active',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Active',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add([
            'name' => 'redeemable',
            'type' => Select::class,
            'options' => [
                'label' => 'Redeemable',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'empty_option' => '---Please select option---',
                'value_options' => [
                    VoucherCodeModel::REDEEM_WEB	=> 'Allow only on website.',
                    VoucherCodeModel::REDEEM_FAIR	=> 'Allow only at fairs.',
                    VoucherCodeModel::REDEEM_BOTH  => 'Allow on website and at fairs.'
                ],
            ],
        ]);

        $this->add([
            'name' => 'code',
            'type' => Text::class,
            'attributes' => [
                'placeholder' => 'Code',
                'autofocus' => true,
            ],
            'options' => [
                'label' => 'Code',
                'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'description',
            'type' => Text::class,
            'attributes' => [
                'placeholder' => 'Description',
                'autofocus' => true,
            ],
            'options' => [
                'label' => 'Description',
                'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'quantity',
            'type' => Number::class,
            'attributes' => [
                'placeholder' => 'Quantity',
                'autofocus' => true,
                'min' => '-1',
                'step' => '1',
                'value' => '-1',
            ],
            'options' => [
                'label' => 'Quantity',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'help-block' => '-1 = infinite number available',
            ],
        ]);

        $this->add([
            'name' => 'limitCustomer',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Limit No Per Customer',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add([
            'name' => 'noPerCustomer',
            'type' => Number::class,
            'attributes' => [
                'placeholder' => 'No. Per Customer',
                'min' => '-1',
                'step' => '1',
                'autofocus' => true,
                'value' => '-1',
            ],
            'options' => [
                'label' => 'No. Per Customer',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'help-block' => '-1 = infinite number available',
            ],
        ]);

        $this->add([
            'name' => 'minCartCost',
            'type' => Number::class,
            'attributes' => [
                'autofocus' => true,
                'min' => '0.00',
                'step' => '0.01',
                'value' => '0.00',
            ],
            'options' => [
                'label' => 'Minimum Cart Cost',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'help-block' => 'Enter the minimum cost this voucher will be valid for. Do not include the currency sign or commas.',
            ],
        ]);

        $this->add([
            'name' => 'discountOperation',
            'type' => Select::class,
            'options' => [
                'label' => 'Discount Operation',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'empty_option' => '---Please select option---',
                'value_options' => [
                    VoucherCodeModel::DISCOUNT_CATEGORY             => 'Subtract fixed amount from qualifying products only',
                    VoucherCodeModel::DISCOUNT_CATEGORY_PERCENTAGE  => 'Subtract percentage from qualifying products only',
                    VoucherCodeModel::DISCOUNT_SUBTOTAL	            => 'Subtract fixed amount from subtotal',
                    VoucherCodeModel::DISCOUNT_SUBTOTAL_PERCENTAGE	=> 'Subtract percentage form subtotal',
                    VoucherCodeModel::DISCOUNT_SHIPPING             => 'Subtract fixed amount form shipping',
                    VoucherCodeModel::DISCOUNT_SHIPPING_PERCENTAGE  => 'Subtract percentage from shipping',
                ],
            ],
        ]);

        $this->add([
            'name' => 'discountAmount',
            'type' => Number::class,
            'attributes' => [
                'autofocus' => true,
                'min' => '0.00',
                'step' => '0.01',
                'value' => '0.00',
            ],
            'options' => [
                'label' => 'Discount Amount',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'help-block' => 'Enter the cost or percentage this voucher will be apply. Do not include the currency sign or commas or % sign.',
            ],
        ]);

        $this->add([
            'name' => 'startDate',
            'type' => Date::class,
            'options' => [
                'label' => 'Start Date',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 date-time-pick',
                //'add-on-append' => '<i class="fa fa-calendar"></i>',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'Y-m-d'
            ],
            'attributes' => [
                'class' => 'date-time-pick',
                'placeholder' => 'End Date',
            ],
        ]);

        $this->add([
            'name' => 'expiry',
            'type' => Date::class,
            'options' => [
                'label' => 'Expiry',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 date-time-pick',
                //'add-on-append' => '<i class="fa fa-calendar"></i>',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'Y-m-d'
            ],
            'attributes' => [
                'class' => 'date-time-pick',
                'placeholder' => 'Expiry',
            ],
        ]);

        $this->add([
            'name' => 'productCategories',
            'type' => ProductCategoryList::class,
            'options' => [
                'label' => 'Categories',
                'required' => true,
                'empty_option' => null,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-8',
                'label_attributes' => [
                    'class' => 'col-sm-4',
                ],
                'twb-form-group-size' => 'col-sm-6',
                'help-block' => '<ul class="text-info">
                  <li>For Windows & Linux: Hold down the control (ctrl) button to select multiple options</li>
                  <li>For Mac: Hold down the command button to select multiple options</li>
                  <li>NB. If a parent category is selected then the voucher will apply to all it\'s 
                  sub-categories 
                  too.</li>
                </ul>',
            ],
            'attributes' => [
                'multiple' => true,
                'size' => 10,
            ],
        ]);

        $this->add([
            'name' => 'zones',
            'type' => PostZoneList::class,
            'options' => [
                'label' => 'Zones',
                'required' => true,
                'empty_option' => null,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-8',
                'label_attributes' => [
                    'class' => 'col-sm-4',
                ],
                'twb-form-group-size' => 'col-sm-6',
                'help-block' => '<ul class="text-info">
                  <li>For Windows & Linux: Hold down the control (ctrl) button to select multiple options</li>
                  <li>For Mac: Hold down the command button to select multiple options</li>
                </ul>'
            ],
            'attributes' => [
                'multiple' => true,
                'size' => 10
            ],
        ]);

        $this->add([
            'name' => 'voucherId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
    }
}