<?php

namespace Newsletter\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\EmailAddress;
use Zend\Validator\Hostname;
use Zend\Validator\StringLength;

/**
 * Class Newsletter
 *
 * @package Newsletter\InputFilter
 * @method InputFilterPluginManager getServiceLocator()
 */
class SubscriberInputFilter extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $this->add([
            'name' => 'subscriberId',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
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
                ['name' => EmailAddress::class, 'options' => [
                    'allow'            => Hostname::ALLOW_DNS,
                    'useMxCheck'       => true,
                    'useDeepMxCheck'   => true
                ]],
            ],
        ]);

        $this->add([
            'name' => 'subscribe',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name' => 'dateCreated',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);
    }

    public function addEmailNoRecordExists($exclude = null)
    {
        $exclude = (!$exclude) ?: [
            'field' => 'email',
            'value' => $exclude,
        ];

        $this->get('email')
            ->getValidatorChain()
            ->attachByName(NoRecordExists::class, [
                'table'     => 'newsletterSubscriber',
                'field'     => 'email',
                'adapter'   => $this->getServiceLocator()
                                    ->getServiceLocator()
                                    ->get('Zend\Db\Adapter\Adapter'),
                'exclude'   => $exclude,
            ]);

        return $this;
    }
}