<?php

namespace ShopDomPdf\View\Model;

use ShopDomPdf\Options\PdfOptions;
use Laminas\View\Model\ViewModel;


class PdfModel extends ViewModel
{
    /**
     * PDF probably won't need to be captured into a 
     * a parent container by default.
     * 
     * @var string
     */
    protected $captureTo = null;

    /**
     * PDF is usually terminal
     * 
     * @var bool
     */
    protected $terminate = true;

    /**
     * @var PdfOptions
     */
    protected $pdfOptions;

    /**
     * @return PdfOptions
     */
    public function getPdfOptions()
    {
        return $this->pdfOptions;
    }

    /**
     * @param PdfOptions $pdfOptions
     * @return $this
     */
    public function setPdfOptions(PdfOptions $pdfOptions)
    {
        $this->pdfOptions = $pdfOptions;
        return $this;
    }
}
