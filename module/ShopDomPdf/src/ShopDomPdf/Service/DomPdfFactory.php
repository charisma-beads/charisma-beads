<?php

namespace ShopDomPdf\Service;

use ShopDomPdf\Options\DomPdfOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
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
