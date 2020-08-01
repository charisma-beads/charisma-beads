<?php

declare(strict_types=1);

namespace User\InputFilter;

use Common\Filter\Ucwords;
use User\Options\LoginOptions;
use Laminas\Db\Adapter\Adapter;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterPluginManager;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;
use Laminas\Validator\Db\NoRecordExists;
use Laminas\Validator\Db\RecordExists;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Hostname;
use Laminas\Validator\Identical;
use Laminas\Validator\StringLength;

class UserInputFilter extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init(): void
    {
        $this->add([
            'name' => 'userId',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => ToInt::class],
            ],
        ]);

        $this->add([
            'name' => 'firstname',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Ucwords::class],
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
            'name' => 'lastname',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Ucwords::class],
            ],
            'validators' => [
                ['name' => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'passwd',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name' => 'passwd-confirm',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => Identical::class, 'options' => [
                    'token' => 'passwd',
                ]],
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
                ['name' => EmailAddress::class, 'options' => $this->getLoginOptions()->getEmailValidateOptions()],
            ],
        ]);

        $this->add([
            'name' => 'role',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);
    }

    public function addPasswordLength(string $type): UserInputFilter
    {
        $type = ucfirst($type);

        $options = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(LoginOptions::class);

        $minMethod = 'get' . $type . 'MinPasswordLength';
        $maxMethod = 'get' . $type . 'MaxPasswordLength';

        $this->get('passwd')
            ->getValidatorChain()
            ->attachByName(StringLength::class, [
                'min' => $options->$minMethod(),
                'max' => $options->$maxMethod(),
                'encoding' => 'UTF-8',
            ]);

        return $this;
    }

    public function addEmailNoRecordExists(?string $exclude): UserInputFilter
    {
        $exclude = (!$exclude) ?: [
            'field' => 'email',
            'value' => $exclude,
        ];

        $this->get('email')
            ->getValidatorChain()
            ->attachByName(NoRecordExists::class, [
                'table' => 'user',
                'field' => 'email',
                'adapter' => $this->getServiceLocator()->getServiceLocator()->get(Adapter::class),
                'exclude' => $exclude,
            ]);

        return $this;
    }

    public function addEmailRecordExists(?string $exclude): UserInputFilter
    {
        $exclude = (!$exclude) ?: [
            'field' => 'email',
            'value' => $exclude,
        ];

        $this->get('email')
            ->getValidatorChain()
            ->attachByName(RecordExists::class, [
                'table' => 'user',
                'field' => 'email',
                'adapter' => $this->getServiceLocator()->getServiceLocator()->get(Adapter::class),
                'exclude' => $exclude,
            ]);

        return $this;
    }

    /**
     * @return LoginOptions
     */
    protected function getLoginOptions(): LoginOptions
    {
        /** @var LoginOptions $options */
        $options = $this->getServiceLocator()->getServiceLocator()->get(LoginOptions::class);
        return $options;
    }
}
