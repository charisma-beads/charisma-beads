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

use Shop\Form\Settings\Paypal\CredentialPairsFieldSet;
use Zend\Filter\Boolean;
use Zend\Filter\StringToUpper;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Shop\Options\PaypalOptions;
use Zend\Validator\StringLength;

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
            'name' => 'currency_code',
            'type' => Text::class,
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
            'type'			=> Select::class,
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
            'name'			=> 'log_enabled',
            'type'			=> Checkbox::class,
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
            'name'			=> 'log_level',
            'type'			=> Select::class,
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
            'name'			=> 'payment_method',
            'type'			=> Select::class,
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
            'type' => CredentialPairsFieldSet::class,
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
            'currency_code' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => StringToUpper::class]
                ],
                'validators' => [
                    ['name' => StringLength::class, 'options' => [
                        'max' => 3,
                        'min' => 3,
                        'encoding' => 'UTF-8',
                    ]]
                ],
            ],
            'mode' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'log_enabled' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'log_level' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'payment_method' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
        ];
    }
}
