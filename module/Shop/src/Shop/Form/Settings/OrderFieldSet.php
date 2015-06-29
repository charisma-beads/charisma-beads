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

use Shop\Options\OrderOptions;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class OrderFieldSet
 *
 * @package Shop\Form\Settings
 */
class OrderFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new OrderOptions());
    }

    public function init()
    {
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

        $this->add([
            'name'			=> 'emailCustomerOnStatusChange',
            'type'			=> 'checkbox',
            'options'		=> [
                'label'			=> 'Email Customer On Order Status Change',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'sm-8 col-sm-offset-4',
            ],
        ]);
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [

        ];
    }
}