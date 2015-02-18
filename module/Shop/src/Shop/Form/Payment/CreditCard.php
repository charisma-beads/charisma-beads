<?php
namespace Shop\Form\Payment;

use Zend\Form\Form;

class CreditCard extends Form
{
    /**
     * @var DateTime
     */
    protected $date;
    
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        
        $this->date = new \DateTime();
        
    }
    
    public function init()
    {
        $this->add([
            'name'	=> 'orderId',
            'type'	=> 'hidden',
        ]);
        
        $this->add([
            'name'	=> 'total',
            'type'	=> 'hidden',
        ]);
        
        $this->add([
            'name' => 'ccType',
            'type' => 'radio',
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
            'type' => 'text',
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
            'type' => 'number',
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
            'type' => 'number',
            'attributes'    => [
                'placeholder'		=> 'CVV2',
                'autofocus'			=> true,
                'maxlength' => 3,
                'min'  => '100',
                'max'  => '999',
            ],
            'options'       => [
                'label' => 'CVV2:',
            ],
        ]);
        
        $this->add([
            'name' => 'ccExpiryDate',
            'type' => 'MonthSelect',
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
            'type' => 'MonthSelect',
            'attributes'    => [
                'autofocus'			=> true,
            ],
            'options'       => [
                'label' => 'Expiry Date:',
                'min_year' => $this->getYears(-10),
                'max_year' => $this->getYears(),
            ],
        ]);
        
        $this->add([
            'name' => 'ccIssueNumber',
            'type' => 'number',
            'attributes' => [
                'placeholder' => 'Issue Number',
                'maxlength'	=> '4',
            ],
            'options' => [
                'label' => 'Issue Number',
            ],
        ]);
        
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
