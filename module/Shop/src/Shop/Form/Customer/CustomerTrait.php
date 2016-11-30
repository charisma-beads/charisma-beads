<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Customer;

use TwbBundle\Form\View\Helper\TwbBundleForm;

/**
 * Class CustomerTrait
 *
 * @package Shop\Form\Customer
 */
trait CustomerTrait
{
    public function addElements()
    {
        $this->add([
            'name' => 'prefixId',
            'type' => 'CustomerPrefixList',
            'attributes'	=> [
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Prefix:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);
         
        $this->add([
            'name' => 'firstname',
            'type' => 'text',
            'options'		=> [
                'label' => 'Firstname:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);
         
        $this->add([
            'name' => 'lastname',
            'type' => 'text',
            'options'		=> [
                'label' => 'Lastname:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'label' => 'Email:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);
    }
}
