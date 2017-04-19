<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Form\Voucher;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Filter\StringToUpper;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Fieldset;
use Zend\I18n\Filter\Alnum;
use Zend\I18n\Validator\Alnum as AlnumValidator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;

/**\
 * Class Voucher
 *
 * @package Shop\Form\Voucher
 */
class VoucherFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function init()
    {
        $this->add([
            'name' => 'code',
            'type' => Text::class,
            'attributes' => [
                'placeholder' => 'Code',
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
                'required' => false,
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
                ],
            ],
        ];
    }
}