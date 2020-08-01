<?php

namespace News\Event;

use Navigation\Service\MenuService;
use Navigation\Service\SiteMapService;
use News\Service\NewsService;
use Laminas\EventManager\Event;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;


class SiteMapListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            SiteMapService::class,
        ], ['uthando.site-map'], [$this, 'addPages']);
    }

    public function addPages(Event $e)
    {
        /* @var \Laminas\Navigation\Navigation $navigation */
        $navigation = $e->getParam('navigation');

        /* @var NewsService $newsService */
        $newsService = $e->getTarget()->getService(NewsService::class);

        /* @var MenuService $menuService */
        $menuService = $e->getTarget()->getService(MenuService::class);

        $newsItems = $newsService->search([
            'sort' => '-dateCreated',
        ]);

        $pages = [];

        /* @var \News\Model\NewsModel $newsItem */
        foreach ($newsItems as $newsItem) {
            $pages[$newsItem->getSlug()] = [
                'label'     => $newsItem->getTitle(),
                'route'     => 'news',
                'params'    => [
                    'news-item' => $newsItem->getSlug(),
                ],
            ];
        }

        // find shop page
        $newsPage = $navigation->findOneByRoute('news-list');

        // add categories to shop page
        $newsPage->addPages($menuService->preparePages($pages));

    }
}
