<?php

declare(strict_types=1);

namespace Common\Filter\Service;

use HTMLPurifier;
use HTMLPurifier_Config;
use HTMLPurifier_HTMLDefinition;
use Interop\Container\ContainerInterface;
use Traversable;
use Common\Filter\HtmlPurifierFilter;
use Common\Options\HtmlPurifierOptions;
use Laminas\Filter\FilterPluginManager;
use Laminas\ServiceManager\Exception\InvalidServiceException;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class HtmlPurifierFactory implements FactoryInterface
{
    /**
     * Options to pass to the constructor (when used in v2), if any.
     *
     * @param null|array
     */
    private $creationOptions = [];

    public function __construct($creationOptions = null)
    {
        if (null === $creationOptions) {
            return;
        }

        if ($creationOptions instanceof Traversable) {
            $creationOptions = iterator_to_array($creationOptions);
        }

        if (! is_array($creationOptions)) {
            throw new InvalidServiceException(sprintf(
                '%s cannot use non-array, non-traversable creation options; received %s',
                __CLASS__,
                (is_object($creationOptions) ? get_class($creationOptions) : gettype($creationOptions))
            ));
        }

        $this->creationOptions = $creationOptions;
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): HtmlPurifierFilter
    {
        /** @var FilterPluginManager $container */
        //$config = $container->getServiceLocator()->get('config');

        $htmlPurifierOptions = new HtmlPurifierOptions();

        $config = array_merge($htmlPurifierOptions->getConfig(), $options);

        $defaultConfig = HTMLPurifier_Config::createDefault();

        foreach ($config as $key => $value) {
            $defaultConfig->set($key, $value);
        }

        if ($def = $defaultConfig->maybeGetRawHTMLDefinition()) {
            $htmlDefinitions = $htmlPurifierOptions->getHtmlDefinition();

            foreach ($htmlDefinitions['elements'] as $el) {
                $def->addElement($el[0], $el[1], $el[2], $el[3], $el[4]);
            }

            foreach ($htmlDefinitions['attributes'] as $attr) {
                $def->addAttribute($attr[0], $attr[1], $attr[2]);
            }
        }

        $htmlPurifier = new HTMLPurifier($defaultConfig);

        return new HtmlPurifierFilter($htmlPurifier);
    }

    public function createService(ServiceLocatorInterface $serviceLocator): HtmlPurifierFilter
    {
        return $this($serviceLocator, self::class, $this->creationOptions);
    }

    public function setCreationOptions(array $options)
    {
        $this->creationOptions = $options;
    }
}
