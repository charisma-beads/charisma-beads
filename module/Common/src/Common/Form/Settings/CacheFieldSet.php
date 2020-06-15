<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Common\Form\Settings
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Common\Form\Settings;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Common\Form\Element\CacheAdapterSelect;
use Common\Form\Element\CachePluginsSelect;
use Common\Form\Settings\Cache\FileSystemFieldSet;
use Common\Hydrator\Strategy\OptionsStrategy;
use Common\Options\CacheOptions;
use Zend\Filter\Boolean;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Checkbox;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;


/**
 * Class CacheFieldSet
 *
 * @package Common\Form\Settings
 */
class CacheFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $hydrator = new ClassMethods();
        $hydrator->addStrategy('options', new OptionsStrategy());

        $this->setHydrator($hydrator);
        $this->setObject(new CacheOptions());
    }

    public function init()
    {
        $this->add([
            'type' => Checkbox::class,
            'name' => 'enabled',
            'options' => [
                'label' => 'Enabled',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' 		=> false,
                'column-size' => 'md-8 col-md-offset-4',
            ],
        ]);

        $this->add([
            'type' => CacheAdapterSelect::class,
            'name' => 'adapter',
            'options' => [
                'label' => 'Adapter',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
        ]);

        $this->add([
            'type' => CachePluginsSelect::class,
            'name' => 'plugins',
            'options' => [
                'label' => 'Plugins',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-8',
                'label_attributes' => [
                    'class' => 'col-md-4',
                ],
            ],
            'attributes' => [
                'multiple' => true,
                'size' => 5,
            ],
        ]);

        $this->add([
            'type' => FileSystemFieldSet::class,
            'name' => 'options',
            'attributes' => [
                'class' => 'col-md-12',
            ],
            'options' => [
                'label' => 'File System Cache Options',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
       return [
           'enabled' => [
               'required' => true,
               'allow_empty' => true,
               'filters' => [
                   ['name' => StringTrim::class],
                   ['name' => StripTags::class,],
                   ['name' => Boolean::class, 'options' => [
                       'type' => Boolean::TYPE_ZERO_STRING,
                   ]],
               ],
           ],
           'adapter' => [
               'required' => true,
               'filters' => [
                   ['name' => StringTrim::class],
                   ['name' => StripTags::class,],
               ],
           ],
           'plugins' => [
               'required' => true,
               'filters' => [
                   ['name' => StringTrim::class],
                   ['name' => StripTags::class,],
               ],
           ],
       ];
    }
}
