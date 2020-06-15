<?php

namespace ShopDomPdf\Service;

use ShopDomPdf\Options\DomPdfOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class DomPdfOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $config = (isset($config['uthando_dompdf']['dompdf_options'])) ? $config['uthando_dompdf']['dompdf_options'] : [];

        $options = new DomPdfOptions($config);

        return $options;
    }
}
