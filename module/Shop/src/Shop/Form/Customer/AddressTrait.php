<?php
namespace Shop\Form\Customer;

use TwbBundle\Form\View\Helper\TwbBundleForm;

trait AddressTrait
{
    public function addElements()
    {
        $this->add([
            'name' => 'address1',
            'type'  => 'text',
            'attributes' => [
                'placeholder'    => 'Address Line 1:',
                'autofocus'      => true,
                'autocapitalize' => 'words',
            ],
            'options' => [
                'label' => 'Address Line 1:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'address2',
            'type'  => 'text',
            'attributes' => [
                'placeholder'      => 'Address Line 2:',
                'autofocus'        => true,
                'autocapitalize'   => 'words'
            ],
            'options' => [
                'label' => 'Address Line 2:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'address3',
            'type'  => 'text',
            'attributes' => [
                'placeholder'     => 'Address Line 3:',
                'autofocus'       => true,
                'autocapitalize'  => 'words'
            ],
            'options' => [
                'label' => 'Address Line 3:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'city',
            'type'  => 'text',
            'attributes' => [
                'placeholder'     => 'City\Town:',
                'autofocus'       => true,
                'autocapitalize'  => 'words',
            ],
            'options' => [
                'label' => 'City\Town:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'provinceId',
            'type'  => 'CountryProvinceList',
            'attributes' => [
                'id'       => 'provinceId',
            ],
            'options' => [
                'label' => 'County\Province:',
                'country_id' => 1,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'postcode',
            'type'  => 'text',
            'attributes' => [
                'placeholder'       => 'PostCode:',
                'autofocus'         => true,
                'autocapitalize'	=> 'characters',
            ],
            'options' => [
                'label' => 'Postcode:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'countryId',
            'type' => 'CountryList',
            'attributes' => [
                'id' => 'countryId',
            ],
            'options' => [
                'label' => 'Country',
                'country_id' => 1,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name'			=> 'phone',
            'type'			=> 'text',
            'attributes'	=> [
                'placeholder'	=> 'Phone No.:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label' => 'Phone No.:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }
}
