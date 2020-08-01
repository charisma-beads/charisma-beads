<?php

namespace Shop\InputFilter;

use Laminas\Filter\Digits;
use Laminas\Filter\PregReplace;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsFloat;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\CreditCard;
use Laminas\Validator\StringLength;

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
                ['name' => \Laminas\Validator\Digits::class],
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
                ['name' => \Laminas\Validator\Digits::class],
                ['name' => StringLength::class, 'options' => [
                    'min'      => 1,
                    'max'      => 3,
                    'encoding' => 'UTF-8', // E
                ]],
            ],
        ]);
    }
}
