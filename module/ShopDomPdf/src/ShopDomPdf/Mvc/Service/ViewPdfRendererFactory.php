<?php

namespace ShopDomPdf\Mvc\Service;

use Dompdf\Dompdf;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ShopDomPdf\View\Renderer\PdfRenderer;


class ViewPdfRendererFactory implements FactoryInterface
{
    /**
     * Create and return the PDF view renderer
     *
     * @param  ServiceLocatorInterface $serviceLocator 
     * @return PdfRenderer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $resolver = $serviceLocator->get('ViewResolver');
        $renderer = $serviceLocator->get('ViewRenderer');
        
        $pdfRenderer = new PdfRenderer();
        $pdfRenderer->setResolver($resolver);
        $pdfRenderer->setHtmlRenderer($renderer);
        $pdfRenderer->setEngine($serviceLocator->get(Dompdf::class));
        
        return $pdfRenderer;
    }
}
