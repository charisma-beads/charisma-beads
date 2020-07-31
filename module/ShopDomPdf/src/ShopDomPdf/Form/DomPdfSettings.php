<?php

namespace ShopDomPdf\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Form;


class DomPdfSettings extends Form
{
    /**
     * Set up the form elements
     */
    public function init()
    {
        $this->add([
            'type' => PdfOptionsFieldSet::class,
            'name' => 'pdf_options',
            'options' => [
                'label' => 'PDF Options',
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);

        $this->add([
            'type' => DomPdfOptionsFieldSet::class,
            'name' => 'dompdf_options',
            'options' => [
                'label' => 'DOMPDF Options',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);
    }
}
