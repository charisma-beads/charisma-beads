<?php
namespace Shop\Form\Customer;

use TwbBundle\Form\View\Helper\TwbBundleForm;

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
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
         
        $this->add([
            'name' => 'firstname',
            'type' => 'text',
            'options'		=> [
                'label' => 'Firstname:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
         
        $this->add([
            'name' => 'lastname',
            'type' => 'text',
            'options'		=> [
                'label' => 'Lastname:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'label' => 'Email:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }
}
