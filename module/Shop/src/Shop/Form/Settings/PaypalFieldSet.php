<?php
namespace Shop\Form\Settings;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;
use Shop\Options\PaypalOptions;

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
                    'sandbox',
                    'live',
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
                    'FINE', 'INFO', 'WARN', 'ERROR',
                ],
                'column-size' => 'md-8',
            ],
        ]);
        
        $this->add([
            'name' => 'clientId',
            'type' => 'text',
            'options' => [
                'label' => 'Client Id',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name' => 'secret',
            'type' => 'text',
            'options' => [
                'label' => 'Client Secret',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
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
    }
    
    public function getInputFilterSpecification()
    {
        return [];
    }
}
