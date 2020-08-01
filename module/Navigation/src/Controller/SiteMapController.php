<?php

namespace Navigation\Controller;

use Common\Service\ServiceTrait;
use Navigation\Service\SiteMapService;
use Laminas\Mvc\Controller\AbstractActionController;

/**
 * Class SiteMapController
 *
 * @package Navigation\Controller
 * @method SiteMapService getService()
 */
class SiteMapController extends AbstractActionController
{
    use ServiceTrait;

    /**
     * SiteMapController constructor.
     */
    public function __construct()
    {
        $this->serviceName = SiteMapService::class;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine(
            'Content-Type', 'text/xml'
        );

        $sitemap = $this->getService()->getSiteMap();

        $response->setStatusCode(200);
        $response->setContent($sitemap);

        return $response;
    }
}
