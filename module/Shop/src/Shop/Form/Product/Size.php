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
use Zend\Form\Form;

/**
 * Class Size
 *
 * @package Shop\Form\Product
 */
class Size extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'productSizeId',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'size',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Size:'
            ],
            'options' => [
                'label' => 'Size:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ]
        ]);
    }
} 