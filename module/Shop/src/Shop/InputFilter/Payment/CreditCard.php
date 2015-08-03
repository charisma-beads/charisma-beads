<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Payment
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter\Payment;

use Zend\InputFilter\InputFilter;

/**
 * Class CreditCard
 *
 * @package Shop\InputFilter\Payment
 */
class CreditCard extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'	=> 'orderId',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators'	=> [
                ['name' => 'Int'],
            ],
        ]);
        
        $this->add([
            'name'	=> 'total',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators'	=> [
                ['name' => 'Float'],
            ],
        ]);
        
        $this->add([
            'name' => 'ccType',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);
        
        $this->add([
            'name' => 'ccName',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);
        
        $this->add([
            'name' => 'ccNumber',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'Digits'],
            ],
            'validators'	=> [
                ['name' => 'CreditCard'],
            ],
        ]);
        
        $this->add([
            'name' => 'cvv2',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'Digits'],
            ],
            'validators'	=> [
                ['name' => 'Digits'],
                ['name' => 'StringLength', 'options' => [
                    'min'      => 3,
                    'max'      => 3,
                    'encoding' => 'UTF-8', // E
                ]],
            ],
        ]);
        
        $this->add([
            'name' => 'ccIssueNumber',
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'Digits'],
            ],
            'validators'	=> [
                ['name' => 'Digits'],
                ['name' => 'StringLength', 'options' => [
                    'min'      => 1,
                    'max'      => 3,
                    'encoding' => 'UTF-8', // E
                ]],
            ],
        ]);
    }
}
