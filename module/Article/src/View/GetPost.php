<?php

namespace Article\View;

use Article\Service\ArticleService;
use Common\Service\ServiceManager;
use Common\View\AbstractViewHelper;


class GetPost extends AbstractViewHelper
{
    public function __invoke($slug)
    {
        /* @var $service \Article\Service\ArticleService */
        $service = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
             ->get(ArticleService::class);
        
        $model = $service->getArticleBySlug($slug);
        
        return $model;
    }
}
