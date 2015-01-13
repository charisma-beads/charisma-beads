<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use Shop\Service\Product\Product as ProductService;
use UthandoCommon\View\AbstractViewHelper;

class Product extends AbstractViewHelper
{
    /**
     * @var ProductService
     */
    protected $service;

    public function __invoke($productId)
    {
        if (!$this->service instanceof ProductService) {
            $this->service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get('UthandoServiceManager')
                ->get('ShopProduct');
        }

        return $this->service->getFullProductById($productId);
    }


} 