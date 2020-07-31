<?php

namespace ShopDomPdf\Service;

use ShopDomPdf\Options\DomPdfOptions;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Dompdf\Dompdf;


class DomPdfFactory implements FactoryInterface
{
    /**
     * Creates an instance of Dompdf.
     * 
     * @param  ServiceLocatorInterface $serviceLocator 
     * @return Dompdf
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var DomPdfOptions $config */
        $config = $serviceLocator->get(DomPdfOptions::class);
        $options = $config->toArray();
        
        return new Dompdf($options);
    }
}
