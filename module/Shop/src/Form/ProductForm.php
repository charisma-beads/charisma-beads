<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Form;

use Shop\Form\Element\PostUnitList;
use Shop\Form\Element\ProductCategoryList;
use Shop\Form\Element\ProductGroupList;
use Shop\Form\Element\ProductSizeList;
use Shop\Form\Element\TaxCodeList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;

/**
 * Class Product
 *
 * @package Shop\Form\Product
 */
class ProductForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'productId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'redirectToEdit',
            'type' => Hidden::class,
            'attributes' => [
                'value' => true,
            ],
        ]);

        $this->add([
            'name' => 'enabled',
            'type' => Checkbox::class,
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
            'type' => Checkbox::class,
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
            'type' => Text::class,
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
            'type' => Text::class,
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
            'type' => ProductCategoryList::class,
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
            'type' => Text::class,
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
            'type' => Text::class,
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
            'type' => Textarea::class,
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
            'type' => ProductGroupList::class,
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
            'type' => Text::class,
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
            'type' => Number::class,
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
            'type' => Number::class,
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
            'type' => TaxCodeList::class,
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
            'type' => Checkbox::class,
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
            'type' => Checkbox::class,
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
            'type' => Checkbox::class,
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
            'type' => ProductSizeList::class,
            'options' => [
                'label' => 'Size',
                'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'add-on-append' => new Button('add-size-button', [
                    'label' => 'New Size',
                ]),
            ],
        ]);

        $this->add([
            'name' => 'postUnitId',
            'type' => PostUnitList::class,
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
