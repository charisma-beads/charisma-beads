<?php

namespace Shop\View;

use Shop\Service\ProductService;
use Common\Service\ServiceManager;
use Common\View\AbstractViewHelper;

/**
 * Class Product
 *
 * @package Shop\View
 */
class Product extends AbstractViewHelper
{
    /**
     * @var ProductService
     */
    protected $service;

    /**
     * @param null $productId
     * @return $this|array|mixed|\Shop\Model\ProductModel|\Common\Model\ModelInterface
     */
    public function __invoke($productId = null)
    {
        if (!$this->service instanceof ProductService) {
            $this->service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(ServiceManager::class)
                ->get(ProductService::class);
        }

        if ($productId) {
            return $this->service->getFullProductById($productId);
        }

        return $this;
    }

    public function getLatestProducts($num = 10)
    {
        return $this->service->getLatestProducts($num);
    }

    public function getPrevious($id)
    {
        $prev = $this->service->getMapper()
            ->getPreviousProduct($id);

        return $prev;
    }

    public function getNext($id)
    {
        $next = $this->service->getMapper()
            ->getNextProduct($id);

        return $next;
    }
}
