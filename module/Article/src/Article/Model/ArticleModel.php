<?php

namespace Article\Model;

use Common\Model\DateCreatedTrait;
use Common\Model\DateModifiedTrait;
use Common\Model\Model;
use Common\Model\ModelInterface;
use User\Model\ResourceTrait;
use User\Model\UserTrait;


class ArticleModel implements ModelInterface
{
    use Model,
        UserTrait,
        ResourceTrait,
        DateCreatedTrait,
        DateModifiedTrait;

    /**
     * @var int
     */
    protected $articleId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $pageHits = 0;

    /**
     * @var string
     */
    protected $image;

    /**
     * @var string
     */
    protected $layout;

    /**
     * @var string
     */
    protected $lead;

    /**
     * @return int
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @param $articleId
     * @return $this
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getPageHits()
    {
        return $this->pageHits;
    }

    /**
     * @param $pageHits
     * @return $this
     */
    public function setPageHits($pageHits)
    {
        $this->pageHits = $pageHits;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return string
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param string $lead
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
    }
}
