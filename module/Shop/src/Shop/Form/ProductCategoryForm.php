<?php

namespace Shop\Form;

use Shop\Form\Element\ProductCategoryList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Common\Mapper\AbstractNestedSet as NestedSet;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Radio;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;

/**
 * Class Category
 *
 * @package Shop\Form
 */
class ProductCategoryForm extends Form
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
     * @return \Laminas\Form\Element|\Laminas\Form\ElementInterface
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
            'type' => Hidden::class,
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
            'name' => 'category',
            'type' => Text::class,
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
            'type' => Text::class,
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
            'type' => Checkbox::class,
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

        $aButtonOptions = ['label' => 'Select File','dropdown' => [
            'label' => 'Dropdown',
            'name' => 'dropdownMenu1',
            'list_attributes' => ['aria-labelledby' => 'dropdownMenu1', 'class'=>'dropdown-menu-right'],
            'items' => [
                'Upload Image' => [
                    'item_attributes' => [
                        'id' => 'upload-category-image',
                    ],
                ],
                'Use Existing' => [
                    'item_attributes' => [
                        'id' => 'list-category-image',
                    ],
                ],
            ],
        ]];


        $this->add([
            'name' => 'image',
            'type' => Text::class,
            'options' => [
                'label' => 'Image',
                'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'add-on-append' => new Button('file-select', ['label' => 'Select File','dropdown' => [
                    'label' => 'Dropdown',
                    'name' => 'dropdownMenu1',
                    'list_attributes' => ['aria-labelledby' => 'dropdownMenu1', 'class'=>'dropdown-menu-right'],
                    'items' => [
                        'Upload Image' => [
                            'item_attributes' => [
                                'id' => 'upload-category-image',
                            ],
                        ],
                        'Use Existing' => [
                            'item_attributes' => [
                                'id' => 'list-category-image',
                            ],
                        ],
                    ],
                ]]),
            ],
            'attributes' => [
                'id' => 'product-category-image',
            ]
        ]);

        $this->add([
            'name' => 'parent',
            'type' => ProductCategoryList::class,
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

        if ($this->getCategoryId()) {
            $this->get('parent')->setValue($this->getCategoryId());
        }

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
            'type' => Radio::class,
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
     * @return \Shop\Form\ProductCategoryForm
     */
    public function setCategoryId($categoryId)
    {
        $categoryId = (int)$categoryId;
        $this->categoryId = $categoryId;
        return $this;
    }
}
