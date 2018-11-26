<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class Advert
 *
 * @package Shop\Form
 */
class AdvertForm extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'advertId',
            'type' => Hidden::class,
        ]);
        
        $this->add([
            'name' => 'advert',
            'type' => Text::class,
            'options' => [
                'label' => 'Advert Name',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'enabled',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Enabled',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);
    }
}
