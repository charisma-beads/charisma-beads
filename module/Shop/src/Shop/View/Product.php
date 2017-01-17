<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\View;

use Shop\Service\Product\Product as ProductService;
use UthandoCommon\View\AbstractViewHelper;

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
     * @return $this|array|mixed|\Shop\Model\Product\Product|\UthandoCommon\Model\ModelInterface
     */
    public function __invoke($productId = null)
    {
        if (!$this->service instanceof ProductService) {
            $this->service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get('UthandoServiceManager')
                ->get('ShopProduct');
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
