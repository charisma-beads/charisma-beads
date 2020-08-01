<?php

namespace Newsletter\View\Service;

use Common\Service\ServiceManager;
use Newsletter\Service\MessageService;
use Newsletter\Service\TemplateService;
use Newsletter\View\Renderer\NewsletterEngine;
use Newsletter\View\Renderer\NewsletterRenderer;
use Newsletter\View\Resolver\NewsletterResolver;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;


class NewsletterRendererFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return NewsletterRenderer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator     = $serviceLocator->get(ServiceManager::class);
        $templateService    = $serviceLocator->get(TemplateService::class);
        $messageService     = $serviceLocator->get(MessageService::class);
        $urlHelper          = $serviceLocator->get('ViewHelperManager')->get('url');

        $viewResolver       = new NewsletterResolver();
        $newsletterRenderer = new NewsletterRenderer();
        $engine             = new NewsletterEngine();

        $viewResolver->setTemplateService($templateService);
        $viewResolver->setMessageService($messageService);

        $engine->setUrlHelper($urlHelper);

        $newsletterRenderer->setResolver($viewResolver);
        $newsletterRenderer->setEngine($engine);

        return $newsletterRenderer;
    }
}