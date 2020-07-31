<?php

namespace Shop\InputFilter\Voucher;

use Shop\Model\AbstractOrderCollection;
use Shop\Validator\Voucher as VoucherValidator;
use Laminas\Filter\StringToUpper;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Filter\Alnum;
use Laminas\I18n\Validator\Alnum as AlnumValidator;
use Laminas\Validator\StringLength;
use Laminas\InputFilter\InputFilter;

class VoucherInputFilter extends InputFilter
{
    /**
     * @param AbstractOrderCollection $orderModel
     */
    public function addCodeFilter(AbstractOrderCollection $orderModel)
    {
        $this->add([
            'code' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => StringToUpper::class],
                    ['name' => Alnum::class]
                ],
                'validators' => [
                    ['name' => AlnumValidator::class, 'options' => [
                        'messages' => [
                            AlnumValidator::INVALID         => 'This code is not a valid code.',
                            AlnumValidator::NOT_ALNUM       => 'This code is not a valid code.',
                            AlnumValidator::STRING_EMPTY    => 'Please enter your code.'
                        ]
                    ]],
                    ['name' => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 255,
                    ]],
                    ['name' => VoucherValidator::class, 'options' => [
                        'customer'      => $orderModel->getCustomer(),
                        'order_model'   => $orderModel,
                    ]],
                ],
            ],
        ]);
    }
}