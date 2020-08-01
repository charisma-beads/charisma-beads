<?php

namespace Article\View;

use Article\Service\ArticleService;
use Common\Service\ServiceManager;
use Common\View\AbstractViewHelper;


class RecentPosts extends AbstractViewHelper
{
    public function __invoke($number)
    {
        $service = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
             ->get(ArticleService::class);
        
        $models = $service->getRecentPosts($number);
        
        return $models;
    }
}