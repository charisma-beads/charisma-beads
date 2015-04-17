<?php
namespace Shop\Form\Settings;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;
use Shop\Options\CheckoutOptions;

class CheckoutFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods())
            ->setObject(new CheckoutOptions());
    }
    
    public function init()
    {
        
        $this->add([
            'name'			=> 'payCheck',
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
            'name'			=> 'payPhone',
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
            'name'			=> 'payCreditCard',
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
            'name'			=> 'payPaypal',
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
            'name'			=> 'collectInstore',
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
            'name'			=> 'creditCardPaymentEmail',
            'type'			=> 'UthandoMailTransportList',
            'options'       => [
                'label' => 'Payment Email',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name'			=> 'orderEmail',
            'type'			=> 'UthandoMailTransportList',
            'options'       => [
                'label' => 'Order Email',
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
        
        $this->add([
            'name'			=> 'sendOrderToAdmin',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Send Order To Admin',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
    }
    
    public function getInputFilterSpecification()
    {
        return [];
    }
}
