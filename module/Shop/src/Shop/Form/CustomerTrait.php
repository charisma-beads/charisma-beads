<?php

namespace Shop\Form;

use Shop\Form\Element\CustomerPrefixList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Text;

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
            'type' => CustomerPrefixList::class,
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
            'type' => Text::class,
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
            'type' => Text::class,
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
            'type' => Email::class,
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
