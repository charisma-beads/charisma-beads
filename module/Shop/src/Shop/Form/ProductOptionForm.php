<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form;

use Shop\Form\Element\PostUnitList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Number;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class Option
 *
 * @package Shop\Form
 */
class ProductOptionForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'productOptionId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'productId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name'		=> 'postUnitId',
            'type'		=> PostUnitList::class,
            'options'	=> [
                'label'			=> 'Weight:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'option',
            'type'			=> Text::class,
            'attributes'	=> [
                'placeholder'	=> 'Option:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Option:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'price',
            'type'			=> Number::class,
            'attributes'	=> [
                'placeholder'	=> 'Price:',
                'autofocus'		=> true,
                'step'			=> '0.01'
            ],
            'options'		=> [
                'label'			=> 'Price:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'discountPercent',
            'type'			=> Number::class,
            'attributes'	=> [
                'autofocus'	=> true,
                'min'		=> '0.00',
                'max'		=> '100.00',
                'step'		=> '0.01',
                'value'     => '0',
            ],
            'options'		=> [
                'label'			=> 'Product Discount:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ]
        ]);
    }
} 