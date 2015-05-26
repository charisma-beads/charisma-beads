<?php
namespace Shop\Form\Country;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

class Province extends Form
{
    public function init()
    {
        $this->add([
            'name'	=> 'provinceId',
            'type'	=> 'hidden',
        ]);

        $this->add([
            'name'	=> 'countryId',
            'type'	=> 'hidden',
        ]);

        $this->add([
            'name'			=> 'provinceCode',
            'type'			=> 'text',
            'attributes'	=> [
                'placeholder'	=> 'Province Code:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Province Code:',
                'help-block' => 'Please use the ISO-3166-2 code',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'provinceName',
            'type'			=> 'text',
            'attributes'	=> [
                'placeholder'	=> 'Name:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Name:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name'			=> 'provinceAlternateNames',
            'type'			=> 'text',
            'attributes'	=> [
                'placeholder'	=> 'Alternate Name:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label'		=> 'Alternate Name:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }
}
