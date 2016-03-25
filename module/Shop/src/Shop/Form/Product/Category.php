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
use TwbBundle\View\Helper\TwbBundleButtonGroup;
use UthandoCommon\Mapper\AbstractNestedSet as NestedSet;
use Zend\Form\Element\Button;
use Zend\Form\Form;
use Zend\Form\FormElementManager;

/**
 * Class Category
 *
 * @package Shop\Form\Product
 * @method FormElementManager getServiceLocator()
 */
class Category extends Form
{
    /**
     * @var int
     */
    protected $categoryId;

    public function __construct($name = null, array $options = [])
    {
        if (is_array($name)) {
            $options = $name;
            $name = (isset($options['name'])) ? $options['name'] : null;
        }
        parent::__construct($name, $options);
    }

    /**
     * @param array|\Traversable $options
     * @return \Zend\Form\Element|\Zend\Form\ElementInterface
     */
    public function setOptions($options)
    {
        if (isset($options['productCategoryId'])) {
            $this->categoryId = $options['productCategoryId'];
        }

        return parent::setOptions($options);
    }

    public function init()
    {
        $this->add([
            'name' => 'productCategoryId',
            'type' => 'hidden',
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
            'name' => 'category',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Category',
                'autofocus' => true,
                'autocapitalize' => 'on',
            ],
            'options' => [
                'label' => 'Category',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ]
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
                'help-block' => 'If you leave this blank the the category name will be used for the ident.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'showImage',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Show Image',
                'required' => true,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $aButtonOptions = array('label' => 'Select File','dropdown' => [
            'label' => 'Dropdown',
            'name' => 'dropdownMenu1',
            'list_attributes' => ['aria-labelledby' => 'dropdownMenu1', 'class'=>'dropdown-menu-right'],
            'items' => ['Upload File','Use Existing',]
        ]);


        $this->add([
            'name' => 'image',
            'type' => 'text',
            'options' => [
                'label' => 'Image',
                'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                /*'add-on-append' => new Button('select-button', [
                    'fontAwesome' => 'upload',
                    'attributes' => [
                        'id' => 'upload-category-image-button',
                    ],
                ]),
                'add-on-append' => new Button('list-image-button', [
                    'fontAwesome' => 'list',
                    'class' => 'clearfix',
                    'id' => 'list-category-image-button',
                ]),*/
                'add-on-append' => new Button('file-select', $aButtonOptions),
            ],
            'attributes' => [
                'id' => 'product-category-image',
            ]
        ]);

        $this->add([
            'name' => 'parent',
            'type' => 'ProductCategoryList',
            'attributes' => [
                'class' => 'input-xlarge',
            ],
            'options' => [
                'label' => 'Parent',
                'required' => false,
                'add_top' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $categoryInsertOptions = [
            NestedSet::INSERT_NODE => 'insert after this category.',
            NestedSet::INSERT_CHILD => 'insert as a new sub-category at the top.',

        ];

        if ($this->getCategoryId()) {
            $categoryInsertOptions['noInsert'] = [
                'value' => 'noInsert',
                'selected' => true,
                'label' => 'no change',
            ];
        }

        $this->add([
            'name' => 'categoryInsertType',
            'type' => 'radio',
            'options' => [
                'required' => true,
                'value_options' => array_reverse($categoryInsertOptions, true),
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);
    }

    /**
     * @return number
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     * @return \Shop\Form\Product\Category
     */
    public function setCategoryId($categoryId)
    {
        $categoryId = (int)$categoryId;
        $this->categoryId = $categoryId;
        return $this;
    }
}
