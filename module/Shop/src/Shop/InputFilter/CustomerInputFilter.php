<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\InputFilter\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\InputFilter;

use UthandoCommon\Filter\Ucwords;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\EmailAddress;
use Zend\Validator\GreaterThan;
use Zend\Validator\Hostname;
use Zend\Validator\StringLength;

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
                    ->get('Zend\Db\Adapter\Adapter'),
                'exclude'   => $exclude,
            ]);

        return $this;
    }
}
