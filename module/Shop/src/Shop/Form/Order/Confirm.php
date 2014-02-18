<?php
namespace Shop\Form\Order;

use Shop\Options\CheckoutOptions;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Confirm extends Form implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        $options = $this->getCheckoutOptions();
        
        $this->add(array(
            'name'		=> 'payment_option',
            'type'		=> 'radio',
            'options'	=> array(
                'label'			=> 'Choose Payment Option:',
                'required'		=> true,
                'value_options'	=> $this->getPayOptionsList($options),
            ),
        ));
        
        if ($options->getCollectInstore()) {
            $this->add(array(
                'name'			=> 'collect_instore',
                'type'			=> 'checkbox',
                'options'		=> array(
                    'label'			=> 'Collect Instore:',
                    'required' 		=> false,
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                    'help-inline'	=> 'When collecting, postage will be removed from total'
                ),
            ));
        }
        
        $this->add(array(
            'name'			=> 'requirements',
            'type'			=> 'textarea',
            'attributes'	=> array(
                'placeholder'	=> 'Additional Requirements:',
                'autofocus'		=> true,
            ),
            'options'		=> array(
                'label'		=> 'Additional Requirements:',
                'required'	=> false,
            ),
        ));
        
        $this->add(array(
            'name'		=> 'terms',
            'type'		=> 'select',
            'options'	=> array(
                'label'			=> 'I agree to the Terms of Service',
                'required'		=> true,
                'empty_option'	=> 'No',
                'value_options'	=> array(
                    1 => 'Yes',
                ),
            ),
        ));
    }
    
    public function getPayOptionsList(CheckoutOptions $options)
    {
        $options = $options->toArray();
        $return_array = [];
        
        foreach($options as $key => $value) {
            $ex_key = explode('_', $key);
            if ('pay' === $ex_key[0]  && true === $value) {
                $ex_key[0] = $ex_key[0] . ' by';
                $return_array[$key] = ucwords(implode(' ', $ex_key));
            }
        }
        
        return $return_array;
    }
    
    /**
     * @return \Shop\Options\CheckoutOptions
     */
    public function getCheckoutOptions()
    {
        return $this->getServiceLocator()->get('Shop\Options\Checkout');
    }
}
