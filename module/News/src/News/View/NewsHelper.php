<?php

namespace News\View;

use Common\Service\ServiceManager;
use Common\View\AbstractViewHelper;
use News\Model\NewsModel as NewsModel;
use News\Service\NewsService as NewsService;


class NewsHelper extends AbstractViewHelper
{
    /**
     * @var NewsService
     */
    protected $service;

    /**
     * @return NewsHelper
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getPopular()
    {
        return $this->getService()
            ->getPopularNews(5);
    }

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getRecent()
    {
        return $this->getService()
            ->getRecentNews(5);
    }

    /**
     * @param $id
     * @return NewsModel|null
     */
    public function getPrevious($id)
    {
        $prev = $this->getService()->getMapper()
            ->getPrevious($id);

        return $prev;
    }

    /**
     * @param $id
     * @return NewsModel|null
     */
    public function getNext($id)
    {

        $next = $this->getService()->getMapper()
            ->getNext($id);

        return $next;
    }

    /**
     * @return NewsService
     */
    public function getService()
    {
        if (!$this->service instanceof NewsService) {

            $service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(ServiceManager::class)
                ->get(NewsService::class);
            $this->setService($service);
        }

        return $this->service;
    }

    /**
     * @param NewsService $service
     * @return NewsHelper
     */
    public function setService(NewsService $service)
    {
        $this->service = $service;
        return $this;
    }
}