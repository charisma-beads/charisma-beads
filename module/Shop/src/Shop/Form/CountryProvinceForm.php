<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Country
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
 * Class Province
 *
 * @package Shop\Form\Country
 */
class CountryProvinceForm extends Form
{
    public function init()
    {
        $this->add([
            'name'	=> 'provinceId',
            'type'	=> Hidden::class,
        ]);

        $this->add([
            'name'	=> 'countryId',
            'type'	=> Hidden::class,
        ]);

        $this->add([
            'name'			=> 'provinceCode',
            'type'			=> Text::class,
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
            'type'			=> Text::class,
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
            'type'			=> Text::class,
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
