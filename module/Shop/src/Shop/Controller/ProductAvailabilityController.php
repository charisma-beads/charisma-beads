<?php

namespace Shop\Controller;

use Shop\Service\ProductAvailabilityService;
use Laminas\Mvc\Controller\AbstractActionController;

class ProductAvailabilityController extends AbstractActionController
{
    /**
     * @var ProductAvailabilityService
     */
    private $productAvailabilityService;

    public function __construct(ProductAvailabilityService $productAvailabilityService)
    {
        $this->productAvailabilityService = $productAvailabilityService;
    }

    public function indexAction()
    {
        return parent::indexAction();
    }
}