<?php

namespace News\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;
use News\Model\NewsModel as NewsModel;


class NewsHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $dateTime = new DateTimeStrategy();

        $this->addStrategy('dateCreated', $dateTime);
        $this->addStrategy('dateModified', $dateTime);

        return $this;
    }

    /**
     * Extract values from an object
     *
     * @param NewsModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'newsId'        => $object->getNewsId(),
            'userId'        => $object->getUserId(),
            'title'         => $object->getTitle(),
            'slug'          => $object->getSlug(),
            'content'       => $object->getContent(),
            'description'   => $object->getDescription(),
            'pageHits'      => $object->getPageHits(),
            'image'         => $object->getImage(),
            'layout'        => $object->getLayout(),
            'lead'          => $object->getLead(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
            'dateModified'  => $this->extractValue('dateModified', $object->getDateModified()),
        ];
    }
}