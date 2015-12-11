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

use PayPal\Core\PayPalLoggingLevel;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;
use Shop\Options\PaypalOptions;

/**
 * Class PaypalFieldSet
 *
 * @package Shop\Form\Settings
 */
class PaypalFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods())
            ->setObject(new PaypalOptions());
    }
    
    public function init()
    {
        $this->add([
            'name' => 'currencyCode',
            'type' => 'text',
            'options' => [
                'label' => 'Currency Code',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name'			=> 'mode',
            'type'			=> 'select',
            'options'		=> [
                'label'			=> 'Mode',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'value_options' => [
                    'sandbox'   => 'sandbox',
                    'live'      => 'live',
                ],
                'column-size' => 'md-8',
            ],
        ]);
        
        $this->add([
            'name'			=> 'logEnabled',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Enable Log',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);
        
        $this->add([
            'name'			=> 'logLevel',
            'type'			=> 'select',
            'options'		=> [
                'label'			=> 'Log Level',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'value_options' => [
                    'Error' => 'Error',
                    'Warn'  => 'Warn',
                    'Info'  => 'Info',
                    'Fine'  => 'Fine',
                    'Debug' => 'Debug',
                ],
                'column-size' => 'md-8',
            ],
        ]);
        
        $this->add([
            'name'			=> 'paymentMethod',
            'type'			=> 'select',
            'options'		=> [
                'label'			=> 'Payment Method',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
                'value_options' => [
                    'credit_card' => 'Credit Card',
                    'paypal' => 'Paypal',
                ],
                'column-size' => 'md-8',
            ],
        ]);

        $this->add([
            'type' => 'ShopPaypalCredentialPairsFieldSet',
            'name' => 'credential_pairs',
            'attributes' => [
                'class' => 'col-md-12',
            ],
            'options' => [
                'label' => 'API Credentials',
            ],
        ]);
    }
    
    public function getInputFilterSpecification()
    {
        return [
            'currencyCode' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                    ['name' => 'StringToUpper']
                ],
                'validators' => [
                    ['name' => 'StringLength', 'options' => [
                        'max' => 3,
                        'min' => 3,
                        'encoding' => 'UTF-8',
                    ]]
                ],
            ],
        ];
    }
}
