<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Settings
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Settings;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;
use Shop\Options\CartOptions;

/**
 * Class CartFieldSet
 *
 * @package Shop\Form\Settings
 */
class CartFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods())
            ->setObject(new CartOptions());
    }
    
    public function init()
    {
        
        $this->add([
            'name'			=> 'pay_check',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Cheque Payments',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'pay_phone',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Phone Payments',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'pay_credit_card',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Credit Card Payments',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'pay_paypal',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Paypal Payments',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'collect_instore',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Collect Instore',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);

        $this->add([
            'name'			=> 'auto_increment_cart',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Auto Increment Cart',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);

        $this->add([
            'name'			=> 'shipping_by_weight',
            'type'			=> 'radio',
            'options'		=> [
                'label'			=> 'Shipping Cost',
                'value_options' => [
                    [
                        'value' => '0',
                        'label' => 'By Invoice Value',
                        'label_attributes' => [
                            'class' => 'col-md-12',
                        ],

                    ],
                    [
                        'value' => '1',
                        'label' => 'By Invoice Weight',
                        'label_attributes' => [
                            'class' => 'col-md-12',
                        ],

                    ],
                ],
                'required' 		=> true,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }
    
    public function getInputFilterSpecification()
    {
        return [];
    }
}
