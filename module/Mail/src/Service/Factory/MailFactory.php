<?php

namespace Mail\Service\Factory;

use Mail\Options\MailOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\View\Renderer\PhpRenderer;
use Mail\Service\Mail;


class MailFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Mail
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get(MailOptions::class);

        $view = $this->getRenderer($serviceLocator);

        $mailService = new Mail($view, $options);

        return $mailService;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return array|object|PhpRenderer
     */
    protected function getRenderer(ServiceLocatorInterface $serviceLocator)
    {
        // Check if a view renderer is available and return it
        if ($serviceLocator->has('ViewRenderer')) {
            return $serviceLocator->get('ViewRenderer');
        }

        // Create new PhpRenderer
        $renderer = new PhpRenderer();

        // Set the view script resolver if available
        if ($serviceLocator->has('Laminas\View\Resolver\AggregateResolver')) {
            $renderer->setResolver(
                $serviceLocator->get('Laminas\View\Resolver\AggregateResolver')
            );
        }

        // Set the view helper manager if available
        if ($serviceLocator->has('ViewHelperManager')) {
            $renderer->setHelperPluginManager(
                $serviceLocator->get('ViewHelperManager')
            );
        }

        // Return the new PhpRenderer
        return $renderer;
    }
}
