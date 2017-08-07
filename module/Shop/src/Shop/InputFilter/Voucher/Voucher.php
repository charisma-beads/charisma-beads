<?php
/**
 * Created by PhpStorm.
 * User: shaun
 * Date: 07/08/17
 * Time: 13:32
 */

namespace Shop\InputFilter\Voucher;

use Shop\Model\Order\AbstractOrderCollection;
use Shop\Validator\Voucher as VoucherValidator;
use Zend\Filter\StringToUpper;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Filter\Alnum;
use Zend\I18n\Validator\Alnum as AlnumValidator;
use Zend\Validator\StringLength;
use Zend\InputFilter\InputFilter;

class Voucher extends InputFilter
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