<?php

namespace Contact\InputFilter;

use Common\Validator\Akismet;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\Hostname as HostnameValidator;
use Zend\Validator\StringLength;


class ContactInputFilter extends InputFilter
{
    /**
     * @var bool
     */
    protected $akismetEnabled = false;

    /**
     * @var array
     */
    protected $akismetOptions = [];

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

        if ($this->isAkismetEnabled()) {
            $options = $this->getAkismetOptions();

            $this->get('body')
                ->getValidatorChain()
                ->attachByName(Akismet::class, [
                    'api_key'               => $options['api_key'] ?? null,
                    'blog'                  => $options['blog'] ?? null,
                    'comment_type'          => Akismet::COMMENT_TYPE_CONTACT_FORM,
                    'comment_author'        => 'name',
                    'comment_author_email'  => 'email',
                    'user_agent'            => $options['user_agent'] ?? null,
                    'user_ip'               => $options['user_ip'] ?? null,
            ]);
        }
    }

    /**
     * @return bool
     */
    public function isAkismetEnabled(): bool
    {
        return $this->akismetEnabled;
    }

    /**
     * @param bool $akismetEnabled
     * @return ContactInputFilter
     */
    public function setAkismetEnabled(bool $akismetEnabled): ContactInputFilter
    {
        $this->akismetEnabled = $akismetEnabled;
        return $this;
    }

    /**
     * @return array
     */
    public function getAkismetOptions(): array
    {
        return $this->akismetOptions;
    }

    /**
     * @param array $akismetOptions
     * @return ContactInputFilter
     */
    public function setAkismetOptions(array $akismetOptions): ContactInputFilter
    {
        $this->akismetOptions = $akismetOptions;
        return $this;
    }
}
