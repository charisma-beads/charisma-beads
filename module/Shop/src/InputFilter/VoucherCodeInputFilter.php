<?php

namespace Shop\InputFilter;

use Laminas\Filter\Boolean;
use Laminas\Filter\StringToUpper;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\I18n\Filter\Alnum;
use Laminas\I18n\Filter\NumberFormat;
use Laminas\I18n\Validator\Alnum as AlnumValidator;
use Laminas\I18n\Validator\IsFloat;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;
use Laminas\Validator\Db\NoRecordExists;
use Laminas\Validator\Digits;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

class VoucherCodeInputFilter extends InputFilter implements ServiceLocatorAwareInterface
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
                ['name' => Alnum::class]
            ],
            'validators' => [
                ['name' => AlnumValidator::class],
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'description',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 10,
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
            'name' => 'limitCustomer',
            'required' => false,
            'allow_empty' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Boolean::class],
            ],
        ]);

        $this->add([
            'name' => 'noPerCustomer',
            'required' => false,
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
            'name' => 'discountAmount',
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
            'name' => 'expiry',
            'required' => false,
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
                'adapter' => $this->getServiceLocator()->getServiceLocator()->get('Laminas\Db\Adapter\Adapter'),
                'exclude' => $exclude,
            ]);

        return $this;
    }
}