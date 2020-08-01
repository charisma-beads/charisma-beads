<?php

namespace Newsletter\View\Service;

use Newsletter\View\Renderer\NewsletterRenderer;
use Newsletter\View\Strategy\NewsletterStrategy;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;


class NewsletterStrategyFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return NewsletterStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $newsletterRenderer NewsletterRenderer */
        $newsletterRenderer = $serviceLocator->get(NewsletterRenderer::class);
        $newsletterStrategy = new NewsletterStrategy($newsletterRenderer);

        return $newsletterStrategy;
    }
}