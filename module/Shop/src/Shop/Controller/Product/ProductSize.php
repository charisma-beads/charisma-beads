<?php

namespace Shop\Controller\Product;

use UthandoCommon\Controller\AbstractCrudController;

class ProductSize extends AbstractCrudController
{
    protected $serviceName = 'ShopProductSize';
    protected $route = 'admin/shop/product/size';
} 