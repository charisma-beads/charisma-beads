<?php

namespace Article\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;


class ArticleHydrator extends AbstractHydrator
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
     *
     * @param $object \Article\Model\ArticleModel
     * @return array
     */
    public function extract($object)
    {
        return [
            'articleId'     => $object->getArticleId(),
            'userId'        => $object->getUserId(),
            'title'         => $object->getTitle(),
            'slug'          => $object->getSlug(),
            'content'       => $object->getContent(),
            'description'   => $object->getDescription(),
            'resource'      => $object->getResource(),
            'pageHits'      => $object->getPageHits(),
            'image'         => $object->getImage(),
            'layout'        => $object->getLayout(),
            'lead'          => $object->getLead(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
            'dateModified'  => $this->extractValue('dateModified', $object->getDateModified())
        ];
    }
}
