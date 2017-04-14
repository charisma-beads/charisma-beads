<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Form\Voucher;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Date;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Number;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class Voucher
 *
 * @package Shop\Form
 */
class Code extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'active',
            'type' => 'checkbox',
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
            'name' => 'quantity',
            'type' => Text::class,
            'attributes' => [
                'placeholder' => 'Quantity',
                'autofocus' => true,
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
                'help-block' => 'Enter the minimum cost or percentage this voucher will be valid for. Do not include the currency sign or commas or % sign.',
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
                    '-'	=> 'Subtract fix amount from subtotal',
                    '%'	=> 'Subtract percentage form subtotal',
                    's' => 'Subtract fix amount form shipping'
                ],
            ],
        ]);

        $this->add([
            'name' => 'startDate',
            'type' => Date::class,
            'options' => [
                'label' => 'Start Date',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 date-time-pick',
                'add-on-append' => '<i class="fa fa-calendar"></i>',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'd/m/Y'
            ],
            'attributes' => [
                'class' => 'date-time-pick',
                'placeholder' => 'End Date',
            ],
        ]);

        $this->add([
            'name' => 'endDate',
            'type' => Date::class,
            'options' => [
                'label' => 'End date',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 date-time-pick',
                'add-on-append' => '<i class="fa fa-calendar"></i>',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'd/m/Y'
            ],
            'attributes' => [
                'class' => 'date-time-pick',
                'placeholder' => 'End Date',
            ],
        ]);

        $this->add([
            'name' => 'productCategories',
            'type' => 'ProductCategoryList',
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
            ],
            'attributes' => [
                'multiple' => true,
                'size' => 10,
            ],
        ]);

        $this->add([
            'name' => 'zones',
            'type' => 'PostZoneList',
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