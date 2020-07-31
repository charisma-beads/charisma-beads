<?php

namespace Contact\InputFilter;

use Common\Validator\Akismet;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Hostname as HostnameValidator;
use Laminas\Validator\StringLength;


class ContactInputFilter extends InputFilter
{
    /**
     * Set up elements
     */
    public function init()
    {
        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => EmailAddress::class, 'options' => [
                    'allow' => HostnameValidator::ALLOW_DNS,
                    'domain' => true
                ]],
            ],
        ]);

        $this->add([
            'name' => 'subject',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 140,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'body',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
            ],
        ]);
    }
}
