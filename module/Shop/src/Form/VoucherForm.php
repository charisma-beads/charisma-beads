<?php

namespace Shop\Form;

use Shop\Validator\Voucher;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Filter\StringToUpper;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Laminas\I18n\Filter\Alnum;
use Laminas\I18n\Validator\Alnum as AlnumValidator;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator\StringLength;

/**\
 * Class Voucher
 *
 * @package Shop\Form\Voucher
 */
class VoucherForm extends Form implements InputFilterProviderInterface
{
    public function init()
    {
        $this->add([
            'name' => 'code',
            'type' => Text::class,
            'attributes' => [
                'placeholder' => 'Voucher Code',
                'autofocus' => true,
            ],
            'options' => [
                'label' => 'Code',
                'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
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
                    ['name' => Voucher::class, 'options' => [
                        'customer'      => $this->getOption('customer'),
                        'order_model'   => $this->getOption('order_model'),
                        'country'       => $this->getOption('country'),
                    ]],
                ],
            ],
        ];
    }
}