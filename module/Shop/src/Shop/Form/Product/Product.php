<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Product;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Button;
use Zend\Form\Form;

/**
 * Class Product
 *
 * @package Shop\Form\Product
 */
class Product extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'productId',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'redirectToEdit',
            'type' => 'hidden',
            'attributes' => [
                'value' => true,
            ],
        ]);

        $this->add([
            'name' => 'enabled',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Enabled',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add([
            'name' => 'discontinued',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Discontinued',
                'required' => true,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add([
            'name' => 'sku',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Product Code/SKU',
                'autofocus' => true,
            ],
            'options' => [
                'label' => 'Product Code/SKU',
                'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Product Name/Title',
                'autofocus' => true,
            ],
            'options' => [
                'label' => 'Product Name/Title',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'productCategoryId',
            'type' => 'ProductCategoryList',
            'options' => [
                'label' => 'Category',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'ident',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Ident',
                'autofocus' => true,
                'autocapitalize' => 'off'
            ],
            'options' => [
                'label' => 'Ident',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'help-block' => 'If you leave this blank the the product code and title will be used for the ident.',
            ],
        ]);

        $this->add([
            'name' => 'shortDescription',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Short Description',
                'autofocus' => true,
            ],
            'options' => [
                'label' => 'Short Description',
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
            'type' => 'textarea',
            'attributes' => [
                'placeholder' => 'Product Description',
                'autofocus' => true,
                'class' => 'editable-textarea',
            ],
            'options' => [
                'label' => 'Description',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'productGroupId',
            'type' => 'ProductGroupList',
            'options' => [
                'label' => 'Price Group',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'price',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Price',
                'autofocus' => true,
            ],
            'options' => [
                'label' => 'Price:',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'help-block' => 'Do not include the currency sign or commas.',
            ],
        ]);

        $this->add([
            'name' => 'discountPercent',
            'type' => 'number',
            'attributes' => [
                'autofocus' => true,
                'min' => '0.00',
                'max' => '100.00',
                'step' => '0.01',
                'value' => '0',
            ],
            'options' => [
                'label' => 'Product Discount',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'help-block' => 'Do not include the % sign.',
            ]
        ]);

        $this->add([
            'name' => 'quantity',
            'type' => 'number',
            'attributes' => [
                'autofocus' => true,
                'min' => '-1',
                'step' => '1',
                'value' => '-1',
            ],
            'options' => [
                'label' => 'Quantity',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],

        ]);

        $this->add([
            'name' => 'taxCodeId',
            'type' => 'TaxCodeList',
            'options' => [
                'label' => 'Tax Code',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'addPostage',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Add Postage',
                'required' => true,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add([
            'name' => 'vatInc',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Vat Included',
                'required' => true,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add(array(
            'name' => 'showImage',
            'type' => 'checkbox',
            'options' => array(
                'label' => 'Show Image',
                'required' => true,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ),
        ));

        $this->add([
            'name' => 'productSizeId',
            'type' => 'ProductSizeList',
            'options' => [
                'label' => 'Size',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'add-on-append' => new Button('list-category-image-button', [
                    'label' => 'New Size',
                ]),
            ],
        ]);

        $this->add([
            'name' => 'postUnitId',
            'type' => 'PostUnitList',
            'options' => [
                'label' => 'Weight',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'add-on-append' => new Button('add-weight-button', [
                    'label' => 'New Weight',
                ]),
            ],
        ]);
    }
}
