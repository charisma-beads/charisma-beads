<?php

namespace ShopDomPdf\Mvc\Service;

use ShopDomPdf\View\Renderer\PdfRenderer;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use ShopDomPdf\View\Strategy\PdfStrategy;


class ViewPdfStrategyFactory implements FactoryInterface
{
    /**
     * Create and return the PDF view strategy
     *
     * Retrieves the ViewPdfRenderer service from the service locator, and
     * injects it into the constructor for the PDF strategy.
     *
     * @param  ServiceLocatorInterface $serviceLocator 
     * @return PdfStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $pdfRenderer = $serviceLocator->get(PdfRenderer::class);
        $pdfStrategy = new PdfStrategy($pdfRenderer);
        
        return $pdfStrategy;
    }
}
