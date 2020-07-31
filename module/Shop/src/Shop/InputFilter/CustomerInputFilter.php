<?php

namespace Shop\InputFilter;

use Common\Filter\Ucwords;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterPluginManager;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;
use Laminas\Validator\Db\NoRecordExists;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\Hostname;
use Laminas\Validator\StringLength;

/**
 * Class Customer
 *
 * @package Shop\InputFilter
 * @method InputFilterPluginManager getServiceLocator()
 */
class CustomerInputFilter extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        $this->add([
            'name' => 'customerId',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => IsInt::class],
            ],
        ]);
        
        $this->add([
            'name' => 'userId',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => IsInt::class]
            ],
        ]);
        
        $this->add([
    		'name' => 'prefixId',
    		'required' => true,
    		'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    		],
    		'validators' => [
        		['name' => IsInt::class],
                ['name' => GreaterThan::class, 'options' => [
                    'min' => 0,
                ]],
    		],
		]);
        
        $this->add([
            'name'       => 'firstname',
            'required'   => true,
            'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Ucwords::class],
            ],
            'validators' => [
                ['name'    => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]],
            ],
        ]);
        
        $this->add([
            'name'       => 'lastname',
            'required'   => true,
            'filters'    => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Ucwords::class],
            ],
            'validators' => [
                ['name'    => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]],
            ],
        ]);
        
        $this->add([
    		'name' => 'billingAddressId',
    		'required' => true,
    		'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    		],
    		'validators' => [
        		['name' => IsInt::class],
                ['name' => GreaterThan::class, 'options' => [
                    'min' => 0,
                ]],
    		],
		]);
        
        $this->add([
    		'name' => 'deliveryAddressId',
    		'required' => true,
    		'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
    		],
    		'validators' => [
        		['name' => IsInt::class],
                ['name' => GreaterThan::class, 'options' => [
            		'min' => 0,
                ]],
    		],
		]);

        $this->add([
            'name' => 'email',
            'required' => false,
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
                'table'     => 'customer',
                'field'     => 'email',
                'adapter'   => $this->getServiceLocator()
                    ->getServiceLocator()
                    ->get('Laminas\Db\Adapter\Adapter'),
                'exclude'   => $exclude,
            ]);

        return $this;
    }
}
