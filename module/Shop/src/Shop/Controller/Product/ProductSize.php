<?php

namespace Shop\Controller\Product;

use UthandoCommon\Controller\AbstractCrudController;

class ProductSize extends AbstractCrudController
{
    protected $serviceName = 'Shop\Service\Product\Size';
    protected $route = 'admin/shop/product/size';
} 