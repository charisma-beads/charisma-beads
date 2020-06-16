<?php

use Common\Controller\CaptchaController;
use Common\Db\Adapter\AdapterServiceFactory as DbAdapterServiceFactory;
use Common\Db\Table\AbstractTableFactory;
use Common\Filter\HtmlPurifierFilter;
use Common\Filter\Service\HtmlPurifierFactory;
use Common\Filter\Slug;
use Common\Filter\UcFirst;
use Common\Filter\Ucwords;
use Common\Form\Element\CacheAdapterSelect;
use Common\Form\Element\CachePluginsSelect;
use Common\Form\Element\Captcha;
use Common\Form\Element\LibPhoneNumberCountryList;
use Common\Form\Settings\AkismetFieldSet;
use Common\Form\Settings\Cache\FileSystemFieldSet;
use Common\Form\Settings\CacheFieldSet;
use Common\Form\Settings\CommonSettings;
use Common\Form\Settings\GeneralFieldSet;
use Common\Form\View\Helper\FormSelect;
use Common\I18n\Filter\PhoneNumber;
use Common\I18n\Validator\PhoneNumber as PhoneNumberValidator;
use Common\I18n\Validator\PostCode;
use Common\I18n\View\Helper\LibPhoneNumber;
use Common\Mapper\MapperManager;
use Common\Mapper\MapperManagerFactory;
use Common\Model\ModelManager;
use Common\Model\ModelManagerFactory;
use Common\Mvc\Controller\Settings;
use Common\Options\AkismetOptions;
use Common\Options\CacheOptions;
use Common\Options\DbOptions;
use Common\Options\GeneralOptions;
use Common\Service\Factory\AkismetOptionsFactory;
use Common\Service\Factory\CacheOptionsFactory;
use Common\Service\Factory\DbOptionsFactory;
use Common\Service\Factory\GeneralOptionsFactory;
use Common\Service\Initializer\CacheStorageInitializer;
use Common\Service\ServiceManager;
use Common\Service\ServiceManagerFactory;
use Common\View\Alert;
use Common\View\ConvertToJsDateFormat;
use Common\View\Enabled;
use Common\View\FlashMessenger;
use Common\View\FormatDate;
use Common\View\FormManager;
use Common\View\OptionsHelper;
use Common\View\Request;
use Zend\Cache\Service\StorageCacheFactory;
use Zend\Db\Adapter\Adapter as DbAdapter;

return [
    'common' => [
        'captcha' => [
            'class' => 'dumb'
        ],
    ],
    'controllers' => [
        'invokables' => [
            CaptchaController::class    => CaptchaController::class,
            Settings::class             => Settings::class,
        ],
    ],
    'filters' => [
        'factories' => [
            HtmlPurifierFilter::class => HtmlPurifierFactory::class,
        ]
    ],
    'service_manager' => [
        'abstract_factories' => [
            AbstractTableFactory::class,
        ],
        'factories' => [
            MapperManager::class        => MapperManagerFactory::class,
            ModelManager::class         => ModelManagerFactory::class,
            ServiceManager::class       => ServiceManagerFactory::class,
            DbAdapter::class            => DbAdapterServiceFactory::class,
            StorageCacheFactory::class  => StorageCacheFactory::class,

            AkismetOptions::class       => AkismetOptionsFactory::class,
            CacheOptions::class         => CacheOptionsFactory::class,
            DbOptions::class            => DbOptionsFactory::class,
            GeneralOptions::class       => GeneralOptionsFactory::class
        ],
    ],
    'uthando_services' => [
        'initializers' => [
            CacheStorageInitializer::class => CacheStorageInitializer::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'convertToJsDateFormat' => ConvertToJsDateFormat::class,
            'enabled'               => Enabled::class,
            'formatDate'            => FormatDate::class,
            'formManager'           => FormManager::class,
            'formSelect'            => FormSelect::class,
            'libPhoneNumber'        => LibPhoneNumber::class,
            'optionsHelper'         => OptionsHelper::class,
            'request'               => Request::class,
            'tbAlert'               => Alert::class,
            'tbFlashMessenger'      => FlashMessenger::class,
        ],
        'invokables' => [
            Alert::class                    => Alert::class,
            ConvertToJsDateFormat::class    => ConvertToJsDateFormat::class,
            Enabled::class                  => Enabled::class,
            FlashMessenger::class           => FlashMessenger::class,
            FormatDate::class               => FormatDate::class,
            FormManager::class              => FormManager::class,
            FormSelect::class               => FormSelect::class,
            LibPhoneNumber::class           => LibPhoneNumber::class,
            OptionsHelper::class            => OptionsHelper::class,
            Request::class                  => Request::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'template_map' => include __DIR__ . '/../template_map.php'
    ],
    'router' => [
        'routes' => [
            'captcha-form-generate' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/captcha/[:id]',
                    'defaults' => [
                        '__NAMESPACE__' => 'Common\Controller',
                        'controller'    => CaptchaController::class,
                        'action'        => 'generate'
                    ],
                ],
            ],
        ],
    ],
];