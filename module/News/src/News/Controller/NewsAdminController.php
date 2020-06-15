<?php

namespace News\Controller;

use Common\Controller\AbstractCrudController;
use News\Service\NewsService;


class NewsAdminController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'newsId'];
    protected $serviceName = NewsService::class;
    protected $route = 'admin/news';
    protected $routes = [];
}