<?php

namespace Shop\Form;

use Shop\Form\Element\CountryList;
use Shop\Form\Element\CountryProvinceList;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Text;

/**
 * Class AddressTrait
 *
 * @package Shop\Form
 */
trait CustomerAddressTrait
{
    public function addElements()
    {
        $countyId = ($this->getOption('country')) ?: 1;
        $countyId = (!is_object($countyId)) ? $countyId : $this->getOption('country')->getCountryId();

        $this->add([
            'name' => 'address1',
            'type'  => Text::class,
            'attributes' => [
                'placeholder'    => 'Address Line 1:',
                'autofocus'      => true,
                'autocapitalize' => 'words',
            ],
            'options' => [
                'label' => 'Address Line 1:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-8',
                'label_attributes' => [
                    'class' => 'col-sm-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'address2',
            'type'  => Text::class,
            'attributes' => [
                'placeholder'      => 'Address Line 2:',
                'autofocus'        => true,
                'autocapitalize'   => 'words'
            ],
            'options' => [
                'label' => 'Address Line 2:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-8',
                'label_attributes' => [
                    'class' => 'col-sm-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'address3',
            'type'  => Text::class,
            'attributes' => [
                'placeholder'     => 'Address Line 3:',
                'autofocus'       => true,
                'autocapitalize'  => 'words'
            ],
            'options' => [
                'label' => 'Address Line 3:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-8',
                'label_attributes' => [
                    'class' => 'col-sm-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'city',
            'type'  => Text::class,
            'attributes' => [
                'placeholder'     => 'City\Town:',
                'autofocus'       => true,
                'autocapitalize'  => 'words',
            ],
            'options' => [
                'label' => 'City\Town:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-8',
                'label_attributes' => [
                    'class' => 'col-sm-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'provinceId',
            'type'  => CountryProvinceList::class,
            'attributes' => [
                'id'       => 'provinceId',
            ],
            'options' => [
                'label' => 'County\Province:',
                'country_id' => $countyId,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-8',
                'label_attributes' => [
                    'class' => 'col-sm-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'postcode',
            'type'  => Text::class,
            'attributes' => [
                'placeholder'       => 'PostCode:',
                'autofocus'         => true,
                'autocapitalize'	=> 'characters',
            ],
            'options' => [
                'label' => 'Postcode:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-8',
                'label_attributes' => [
                    'class' => 'col-sm-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'countryId',
            'type' => CountryList::class,
            'attributes' => [
                'id' => 'countryId',
            ],
            'options' => [
                'label' => 'Country',
                'country_id' => $countyId,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-8',
                'label_attributes' => [
                    'class' => 'col-sm-4',
                ],
            ],
        ]);
        
        $this->add([
            'name'			=> 'phone',
            'type'			=> Text::class,
            'attributes'	=> [
                'placeholder'	=> 'Phone No.:',
                'autofocus'		=> true,
            ],
            'options'		=> [
                'label' => 'Phone No.:',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-8',
                'label_attributes' => [
                    'class' => 'col-sm-4',
                ],
            ],
        ]);
    }
}
