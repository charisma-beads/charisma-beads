<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Payment
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use Zend\Filter\Digits;
use Zend\Filter\PregReplace;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsFloat;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\CreditCard;
use Zend\Validator\StringLength;

/**
 * Class CreditCard
 *
 * @package Shop\InputFilter
 */
class CreditCardInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'	=> 'orderId',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'	=> [
                ['name' => IsInt::class],
            ],
        ]);
        
        $this->add([
            'name'	=> 'total',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'	=> [
                ['name' => IsFloat::class],
            ],
        ]);
        
        $this->add([
            'name' => 'ccType',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);
        
        $this->add([
            'name' => 'ccName',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);
        
        $this->add([
            'name' => 'ccNumber',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => PregReplace::class, 'options' => [
                    'pattern'       => '/\s+/',
                    'replacement'   => ''
                ]],
                ['name' => Digits::class],
            ],
            'validators'	=> [
                ['name' => CreditCard::class],
            ],
        ]);
        
        $this->add([
            'name' => 'cvv2',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Digits::class],
            ],
            'validators'	=> [
                ['name' => \Zend\Validator\Digits::class],
                ['name' => StringLength::class, 'options' => [
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
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Digits::class],
            ],
            'validators'	=> [
                ['name' => \Zend\Validator\Digits::class],
                ['name' => StringLength::class, 'options' => [
                    'min'      => 1,
                    'max'      => 3,
                    'encoding' => 'UTF-8', // E
                ]],
            ],
        ]);
    }
}
