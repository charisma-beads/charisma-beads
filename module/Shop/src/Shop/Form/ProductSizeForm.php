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

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class Size
 *
 * @package Shop\Form
 */
class ProductSizeForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'productSizeId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'size',
            'type' => Text::class,
            'attributes' => [
                'placeholder' => 'Size'
            ],
            'options' => [
                'label' => 'Size',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ]
        ]);
    }
} 