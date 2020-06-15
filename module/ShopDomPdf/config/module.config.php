<?php

use Dompdf\Dompdf;
use ShopDomPdf\Controller\SettingsController;
use ShopDomPdf\Form\DomPdfOptionsFieldSet;
use ShopDomPdf\Form\DomPdfSettings;
use ShopDomPdf\Form\PdfOptionsFieldSet;
use ShopDomPdf\Form\PdfTextLineFieldSet;
use ShopDomPdf\Form\PdfTextLineFontFieldSet;
use ShopDomPdf\Form\View\Helper\PdfTextLineFormCollection;
use ShopDomPdf\Mvc\Service\ViewPdfRendererFactory;
use ShopDomPdf\Mvc\Service\ViewPdfStrategyFactory;
use ShopDomPdf\Options\DomPdfOptions;
use ShopDomPdf\Service\DomPdfFactory;
use ShopDomPdf\Service\DomPdfOptionsFactory;
use ShopDomPdf\Service\PdfModelFactory;
use ShopDomPdf\View\Model\PdfModel;
use ShopDomPdf\View\Renderer\PdfRenderer;
use ShopDomPdf\View\Strategy\PdfStrategy;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'invokables' => [
            SettingsController::class => SettingsController::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            DomPdfOptionsFieldSet::class    => InvokableFactory::class,
            DomPdfSettings::class           => InvokableFactory::class,
            PdfOptionsFieldSet::class       => InvokableFactory::class,
            PdfTextLineFieldSet::class      => InvokableFactory::class,
            PdfTextLineFontFieldSet::class  => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'shared' => [
            /**
             * DOMPDF itself has issues rendering twice in a row so we force a
             * new instance to be created.
             */
            DomPdf::class => false
        ],
        'factories' => [
            Dompdf::class           => DomPdfFactory::class,
            DomPdfOptions::class    => DomPdfOptionsFactory::class,
            PdfModel::class         => PdfModelFactory::class,
            PdfRenderer::class      => ViewPdfRendererFactory::class,
            PdfStrategy::class      => ViewPdfStrategyFactory::class,
        ]
    ],
    'view_helpers' => [
        'aliases' => [
            'PdfTextLineFormCollection' => PdfTextLineFormCollection::class,
        ],
        'invokables' => [
            PdfTextLineFormCollection::class => PdfTextLineFormCollection::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            PdfStrategy::class
        ],
        'template_map' => include __DIR__ . '/../template_map.php',
    ],
];
