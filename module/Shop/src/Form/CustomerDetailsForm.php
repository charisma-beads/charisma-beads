<?php

namespace Shop\Form;

use Laminas\Form\Element\Checkbox;
use Laminas\Form\Form;
use Laminas\Hydrator\ClassMethods;
use Laminas\InputFilter\InputFilter;

/**
 * Class CustomerDetails
 *
 * @package Shop\Form
 */
class CustomerDetailsForm extends Form
{   
    public function __construct($name = null, $options = [])
    {
        if (is_array($name)) {
            $options = $name;
            $name = (isset($options['name'])) ? $options['name'] : null;
        }

        parent::__construct($name, $options);
    
        $this->setHydrator(new ClassMethods(false));
        $this->setInputFilter(new InputFilter());
    }
    
    public function init()
    {
        // options are here
        $this->add([
            'type' => CustomerFieldSet::class,
            'name' => 'customer',
            'options' => [
                'label' => 'Customer',
                'use_as_base_fieldset' => true,
                'billing_country' => $this->getOption('billing_country'),
                'delivery_country' => $this->getOption('delivery_country'),
            ],
        ]);

        $this->get('customer')->initElements();

        $this->add([
            'type' => Checkbox::class,
            'name' => 'shipToBilling',
            'options' => [
                'label'                 => 'Ship to billing address',
                'use_hidden_element'    => true,
                'checked_value'         => '1',
                'unchecked_value'       => '0',
            ], 
        ]);
    }
}
