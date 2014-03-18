<?php
namespace Shop\Form\Payment;

use Zend\Form\Form;

class CreditCard extends Form
{
    protected $months = [
        '0'	=> '--Month--',
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    ];
    
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
        	'name' => 'ccName',
            'type' => 'text',
            'attributes'    => [
                'placehoder'		=> 'Name:',
                'autofocus'			=> true,
                'autocapitalize'    => 'characters'
            ],
            'options'       => [
                'label' => 'Name:',
            ],
        ]);
    }
}
