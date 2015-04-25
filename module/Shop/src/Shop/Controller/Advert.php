<?php
namespace Shop\Controller;

use UthandoCommon\Controller\AbstractCrudController;

class Advert extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'advert'];
    protected $serviceName = 'ShopAdvert';
    protected $route = 'admin/shop/advert';
}