<?php

namespace ShopDomPdf\Service;

use ShopDomPdf\Options\PdfOptions;
use ShopDomPdf\View\Model\PdfModel;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class PdfModelFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $config = (isset($config['uthando_dompdf']['pdf_options'])) ? $config['uthando_dompdf']['pdf_options'] : [];

        $options = new PdfOptions($config);
        $model = new PdfModel();
        $model->setPdfOptions($options);

        return $model;
    }
}
