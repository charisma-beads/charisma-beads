<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\InputFilter\Voucher;

use Zend\Filter\Boolean;
use Zend\Filter\StringToUpper;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\I18n\Filter\NumberFormat;
use Zend\I18n\Validator\IsFloat;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\Digits;
use Zend\Validator\GreaterThan;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class Code extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $this->add([
            'name' => 'voucherId',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => ToInt::class],
            ],
            'validators' => [
                ['name' => Digits::class],
            ],
        ]);

        $this->add([
            'name' => 'code',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => StringToUpper::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'active',
            'required' => false,
            'allow_empty' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Boolean::class],
            ],
        ]);

        $this->add([
            'name' => 'quantity',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'	=> [
                ['name' => NotEmpty::class],
                ['name' => IsInt::class],
                ['name' => GreaterThan::class, 'options'	=> [
                    'min'		=> -1,
                    'inclusive'	=> true,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'minCartCost',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => NumberFormat::class],
            ],
            'validators' => [
                ['name' => IsFloat::class],
            ],
        ]);

        $this->add([
            'name' => 'startDate',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name' => 'endDate',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

    }

    public function addNoRecordExists($exclude = null)
    {
        $exclude = (!$exclude) ?: [
            'field' => 'code',
            'value' => $exclude,
        ];

        $this->get('code')
            ->getValidatorChain()
            ->attachByName(NoRecordExists::class, [
                'table' => 'voucherCodes',
                'field' => 'code',
                'adapter' => $this->getServiceLocator()->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
                'exclude' => $exclude,
            ]);

        return $this;
    }
}