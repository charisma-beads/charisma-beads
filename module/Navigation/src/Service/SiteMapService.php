<?php

namespace Navigation\Service;

use Common\Cache\CacheStorageAwareInterface;
use Common\Cache\CacheTrait;
use Common\Service\AbstractService;
use Navigation\View\Navigation;


class SiteMapService extends AbstractService implements CacheStorageAwareInterface
{
    use CacheTrait,
        NavigationTrait;

    /**
     * Returns a formatted xml sitemap string
     *
     * @return string
     */
    public function getSiteMap()
    {
        $sitemap = $this->getCacheItem('site-map');

        if (null === $sitemap) {
            /* @var $menuService MenuService */
            $menuService = $this->getService(MenuService::class);

            $navigation = $menuService->getPages();

            $argv = $this->prepareEventArguments(compact('navigation'));
            $this->getEventManager()->trigger('uthando.site-map', $this, $argv);

            $sitemap = $this->getService('ViewHelperManager')
                ->get(Navigation::class)
                ->setRole('guest')
                ->sitemap($navigation)
                ->render();

            $this->setCacheItem('site-map', $sitemap);
        }

        return $sitemap;
    }
}
