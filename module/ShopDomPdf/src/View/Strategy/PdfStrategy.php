<?php

namespace ShopDomPdf\View\Strategy;

use ShopDomPdf\Options\PdfOptions;
use ShopDomPdf\View\Model;
use ShopDomPdf\View\Renderer\PdfRenderer;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\View\ViewEvent;


class PdfStrategy implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @var PdfRenderer
     */
    protected $renderer;

    /**
     * Constructor
     *
     * @param  PdfRenderer $renderer
     */
    public function __construct(PdfRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Attach the aggregate to the specified event manager
     *
     * @param  EventManagerInterface $events
     * @param  int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }

    /**
     * Detect if we should use the PdfRenderer based on model type
     *
     * @param  ViewEvent $e
     * @return null|PdfRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();
        
        if ($model instanceof Model\PdfModel) {
            return $this->renderer;
        }

        return;
    }

    /**
     * Inject the response with the PDF payload and appropriate Content-Type header
     *
     * @param  ViewEvent $e
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();

        if ($renderer !== $this->renderer) {
            // Discovered renderer is not ours; do nothing
            return;
        }

        $result = $e->getResult();

        if (!is_string($result)) {
            // @todo Potentially throw an exception here since we should *always* get back a result.
            return;
        }
        
        $response = $e->getResponse();
        $response->setContent($result);
        $response->getHeaders()->addHeaderLine('content-type', 'application/pdf');

        /* @var PdfOptions $pdfOptions */
        $pdfOptions = $e->getModel()->getPdfOptions();
        
        $fileName = $pdfOptions->getFileName();
        if (isset($fileName)) {
            if (substr($fileName, -4) != '.pdf') {
                $fileName .= '.pdf';
            }
            
            $response->getHeaders()->addHeaderLine(
            	'Content-Disposition', 
            	'attachment; filename=' . $fileName);
        }
    }
}
