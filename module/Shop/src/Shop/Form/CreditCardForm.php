<?php

namespace Shop\Form;

use DateTime;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\MonthSelect;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Radio;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;

/**
 * Class CreditCard
 *
 * @package Shop\Form\Payment
 */
class CreditCardForm extends Form
{   
    /**
     * @var DateTime
     */
    protected $date;
    
    public function __construct($name = null, $options = [])
    {
        if (is_array($name)) {
            $options = $name;
            $name = (isset($name['name'])) ? $name['name'] : null;
        }
        parent::__construct($name, $options);
        
        $this->date = new \DateTime();
        
    }
    
    public function init()
    {
        $this->add([
            'name'	=> 'orderId',
            'type'	=> Hidden::class,
        ]);
        
        $this->add([
            'name'	=> 'total',
            'type'	=> Hidden::class,
        ]);
        
        $this->add([
            'name' => 'ccType',
            'type' => Radio::class,
            'options' => [
                'label' => 'Card Type:',
                'attributes'    => [
                    'autofocus'			=> true,
                ],
                'value_options' => [
                    'v'     => '<i></i>Visa/Delta/Electron',
                    'm'     => '<i></i>MasterCard/Eurocard',
                    //'d'     => '<i></i>Discover',
                    'sm'    => '<i></i>Switch/Maestro',
                    //'s'     => '<i></i>Solo'
                ],
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
        ]);
        
        $this->add([
        	'name' => 'ccName',
            'type' => Text::class,
            'attributes'    => [
                'placeholder'		=> 'Name on card',
                'autofocus'			=> true,
                'autocapitalize'    => 'characters'
            ],
            'options'       => [
                'label' => 'Name:',
            ],
        ]);
        
        $this->add([
            'name' => 'ccNumber',
            'type' => Text::class,
            'attributes'    => [
                'placeholder'		=> 'Card Number',
                'autofocus'			=> true,
                'autocapitalize'    => 'characters'
            ],
            'options'       => [
                'label' => 'Card Number:',
            ],
        ]);
        
        $this->add([
            'name' => 'cvv2',
            'type' => Text::class,
            'attributes'    => [
                'placeholder'		=> 'CVV2',
                'autofocus'			=> true,
                'maxlength' => 3,
                //'min'  => '000',
                //'max'  => '999',
            ],
            'options'       => [
                'label' => 'CVV2:',
            ],
        ]);
        
        $this->add([
            'name' => 'ccExpiryDate',
            'type' => MonthSelect::class,
            'attributes'    => [
                'autofocus'			=> true,
            ],
            'options'       => [
                'label' => 'Expiry Date:',
                'min_year' => $this->getYears(),
                'max_year' => $this->getYears('10'),
            ],
        ]);
        
        $this->add([
            'name' => 'ccStartDate',
            'type' => MonthSelect::class,
            'attributes'    => [
                'autofocus'			=> true,
            ],
            'options'       => [
                'label' => 'Start Date:',
                'min_year' => $this->getYears(-10),
                'max_year' => $this->getYears(),
            ],
        ]);
        
        $this->add([
            'name' => 'ccIssueNumber',
            'type' => Number::class,
            'attributes' => [
                'placeholder' => 'Issue Number',
                'maxlength'	=> '4',
            ],
            'options' => [
                'label' => 'Issue Number',
            ],
        ]);
        
        $this->add([
            'type' => CustomerAddressFieldSet::class,
            'name' => 'address',
            'options' => [
                'label' => 'Address',
                'country' => $this->options['billing_country'],
            ],
        ]);

        $this->get('address')->initElements();
        
        $this->add([
            'name'    => 'security',
            'type'    => 'csrf',
        ]);
    }
    
    public function getYears($length = null)
    {
        if (null == $length) {
            return $this->date->format('Y');
        }
        
        $date = clone $this->date;
        
        if (substr($length, 0, 1) == '-') {
            return $date->sub(new \DateInterval('P'.substr($length, 1).'Y'))->format('Y');
        } else {
            return $date->add(new \DateInterval('P'.$length.'Y'))->format('Y');
        }
    }
}
