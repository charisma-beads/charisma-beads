<?php

namespace Contact\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Common\Form\Element\LibPhoneNumberCountryList;
use Common\Hydrator\Strategy\CollectionToArrayStrategy;
use Common\I18n\Filter\PhoneNumber;
use Common\I18n\Validator\PhoneNumber as PhoneNumberValidator;
use Contact\Options\DetailsOptions;
use Laminas\Filter\Digits;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Form\Element\Collection;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Fieldset;
use Laminas\Hydrator\ClassMethods;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\StringLength;


class DetailsFieldSet extends Fieldset implements InputFilterProviderInterface
{
    /**
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = [])
    {
        if (is_array($name)) {
            $options = $name;
            $name = (isset($options['name'])) ? $options['name'] : null;
        }

        parent::__construct($name, $options);

        $hydrator = new ClassMethods();
        $hydrator->addStrategy('address', new CollectionToArrayStrategy());
        $hydrator->addStrategy('business_hours', new CollectionToArrayStrategy());

        $this->setHydrator($hydrator)
            ->setObject(new DetailsOptions());
    }

    /**
     * Set up elements
     */
    public function init()
    {
        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Name',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'type' => Collection::class,
            'name' => 'address',
            'options' => [
                'label' => 'Add address lines',
                'label_options' => [
                    'disable_html_escape' => true,
                ],
                'count' => 0,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => [
                    'type' => AbstractLineFieldSet::class,
                ],
            ],
            'attributes' => [
                'class' => 'col-md-12',
            ],
        ]);

        $this->add([
            'name'		=> 'phone_region',
            'type'		=> LibPhoneNumberCountryList::class,
            'options'	=> [
                'label'	=> 'Phone Region',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'phone',
            'type' => Text::class,
            'options' => [
                'label' => 'Phone No',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'mobile',
            'type' => Text::class,
            'options' => [
                'label' => 'Mobile No',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'fax',
            'type' => Text::class,
            'options' => [
                'label' => 'Fax No',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => Email::class,
            'options' => [
                'label' => 'Email Address',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'type' => Collection::class,
            'name' => 'business_hours',
            'options' => [
                'label' => 'Add Business Hours',
                'label_options' => [
                    'disable_html_escape' => true,
                ],
                'count' => 0,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => [
                    'type' => AbstractLineFieldSet::class,
                ],
            ],
            'attributes' => [
                'class' => 'col-md-12',
            ],
        ]);

        $this->add([
            'name' => 'about_us_text',
            'type' => Textarea::class,
            'options' => [
                'label' => 'About Us Text',
                'column-size' => 'md-8',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification(): array
    {
        $countryCode = $this->get('phone_region')->getValue();

        return [
            'name' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 255,
                    ]],
                ],
            ],
            'phone' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Digits::class],
                    ['name' => PhoneNumber::class, 'options' => [
                        'country' => $countryCode,
                    ]]
                ],
                'validators' => [
                    ['name' => PhoneNumberValidator::class, 'options' => [
                        'country' => $countryCode,
                    ]],
                ],
            ],
            'mobile' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Digits::class],
                    ['name' => PhoneNumber::class, 'options' => [
                        'country' => $countryCode,
                    ]]
                ],
                'validators' => [
                    ['name' => PhoneNumberValidator::class, 'options' => [
                        'country' => $countryCode,
                    ]],
                ],
            ],
            'fax' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Digits::class],
                    ['name' => PhoneNumber::class, 'options' => [
                        'country' => $countryCode,
                    ]]
                ],
                'validators' => [
                    ['name' => PhoneNumberValidator::class, 'options' => [
                        'country' => $countryCode,
                    ]],
                ],
            ],
            'email' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => EmailAddress::class],
                ],
            ],
            'about_us_text' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => StringLength::class, 'options' => [
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 255,
                    ]],
                ],
            ],
        ];
    }
}
