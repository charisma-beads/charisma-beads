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
 * Class Image
 *
 * @package Shop\Form\Product
 */
class Image extends Form
{
    public function init()
    {
        $this->add([
        	'name'	=> 'productImageId',
        	'type'	=> 'hidden',
        ]);

        $this->add([
            'name'	=> 'productId',
            'type'	=> 'hidden',
        ]);

        $this->add([
            'name' => 'thumbnail',
            'type' => 'text',
            'options' => [
                'label' => 'Thumbnail:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'readonly' => true,
            ],
        ]);

        $this->add([
            'name' => 'full',
            'type' => 'text',
            'options' => [
                'label' => 'Full Image:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'readonly' => true,
            ],
        ]);

        $this->add([
            'name' => 'isDefault',
            'type' => 'select',
            'options' => [
                'label' => 'Is Default:',
                'value_options' => [
                    '0'	=> 'No',
                    '1'	=> 'Yes',
                ],
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);
    }
}
